<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Order\Shipment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Phrase;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory as ShipmentCollectionFactory;
use Magento\Shipping\Controller\Adminhtml\Order\Shipment\MassPrintShippingLabel;
use Magento\Shipping\Model\Shipping\LabelGenerator;
use Magento\Ui\Component\MassAction\Filter;
use Zend_Pdf_Exception;
use ZipArchive;

class CustomMassPrintShippingLabel extends MassPrintShippingLabel
{
    /** @var DirectoryList */
    protected DirectoryList $directoryList;

    /**
     * Class construct
     *
     * @param DirectoryList $directoryList
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param FileFactory $fileFactory
     * @param LabelGenerator $labelGenerator
     * @param ShipmentCollectionFactory $shipmentCollectionFactory
     */
    public function __construct(
        DirectoryList $directoryList,
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        FileFactory $fileFactory,
        LabelGenerator $labelGenerator,
        ShipmentCollectionFactory $shipmentCollectionFactory,
    ) {
        parent::__construct(
            $context,
            $filter,
            $collectionFactory,
            $fileFactory,
            $labelGenerator,
            $shipmentCollectionFactory
        );

        $this->fileFactory = $fileFactory;
        $this->collectionFactory = $collectionFactory;
        $this->shipmentCollectionFactory = $shipmentCollectionFactory;
        $this->labelGenerator = $labelGenerator;
        $this->directoryList = $directoryList;
    }

    /**
     * Mass Action
     *
     * @param AbstractCollection $collection
     * @return ResponseInterface|ResultInterface
     * @throws LocalizedException
     * @throws Zend_Pdf_Exception
     * @throws FileSystemException
     */
    protected function massAction(AbstractCollection $collection): ResponseInterface|ResultInterface
    {
        $labelsContent = $this->getLabelContent($collection);

        if (!empty($labelsContent['dpl']) || !empty($labelsContent['epl']) || !empty($labelsContent['zpl'])) {
            if (!class_exists(ZipArchive::class)) {
                throw new LocalizedException(
                    new Phrase('\'%1\' file extension is not supported', ['Zip'])
                );
            }

            $tempDir = $this->directoryList->getPath(DirectoryList::VAR_DIR);
            $zipFilename = $tempDir . '/ShippingLabels.zip';
            $zip = new ZipArchive();

            if ($zip->open($zipFilename, ZipArchive::CREATE) === true) {
                $count = 1;

                foreach ($labelsContent as $format => $labels) {
                    foreach ($labels as $incrementId => $label) {
                        if ($format === 'pdf') {
                            $outputPdf = $this->labelGenerator->combineLabelsPdf([$label]);
                            $zip->addFromString(
                                "Shipping-Label-{$count}-({$incrementId}).{$format}",
                                $outputPdf->render()
                            );
                        } else {
                            $zip->addFromString(
                                "Shipping-Label-{$count}-({$incrementId}).{$format}",
                                $label
                            );
                        }

                        $count++;
                    }
                }

                $zip->close();

                return $this->fileFactory->create(
                    'ShippingLabels.zip',
                    [
                        'value' => $zipFilename,
                        'type' => 'filename',
                        'rm' => true
                    ],
                    DirectoryList::VAR_DIR,
                    'application/zip',
                );
            }

            $this->messageManager->addErrorMessage(
                __('Error while generating an archive file with a list of shipment labels.')
            );

            return $this->resultRedirectFactory->create()->setPath('sales/shipment/');
        }

        if (!empty($labelsContent['pdf'])) {
            $outputPdf = $this->labelGenerator->combineLabelsPdf($labelsContent['pdf']);

            return $this->fileFactory->create(
                'ShippingLabels.pdf',
                [
                    'value' => $outputPdf->render(),
                    'type' => 'string'
                ],
                DirectoryList::VAR_DIR,
                'application/pdf'
            );
        }

        $this->messageManager->addErrorMessage(__('There are no shipping labels related to selected orders.'));

        return $this->resultRedirectFactory->create()->setPath('sales/order/');
    }

    /**
     * Get label content
     *
     * @param AbstractCollection $collection
     * @return array
     */
    private function getLabelContent(AbstractCollection $collection): array
    {
        $shipments = $this->shipmentCollectionFactory->create()->setOrderFilter(['in' => $collection->getAllIds()]);
        $labelsContent = [
            'pdf' => [],
            'dpl' => [],
            'epl' => [],
            'zpl' => []
        ];

        if ($shipments->getSize()) {
            /** @var Shipment $shipment */
            foreach ($shipments as $shipment) {
                $labelContent = $shipment->getShippingLabel();

                if (!empty($labelContent)) {
                    $labelFormat = $shipment->getGlsPolandShippingLabelFormat();
                    $incrementId = $shipment->getIncrementId();

                    switch ($labelFormat) {
                        case 'roll_160x100_datamax':
                            $labelsContent['dpl'][$incrementId] = $labelContent;
                            break;
                        case 'roll_160x100_zebra':
                        case 'roll_160x100_zebra_300':
                            $labelsContent['zpl'][$incrementId] = $labelContent;
                            break;
                        case 'roll_160x100_zebra_epl':
                            $labelsContent['epl'][$incrementId] = $labelContent;
                            break;
                        default:
                            $labelsContent['pdf'][$incrementId] = $labelContent;
                            break;
                    }
                }
            }
        }

        return $labelsContent;
    }
}

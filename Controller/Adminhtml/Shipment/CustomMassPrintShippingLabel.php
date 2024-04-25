<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Shipment;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Phrase;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\ResourceModel\Order\Shipment\CollectionFactory;
use Magento\Shipping\Controller\Adminhtml\Shipment\MassPrintShippingLabel;
use Magento\Shipping\Model\Shipping\LabelGenerator;
use Magento\Ui\Component\MassAction\Filter;
use Zend_Pdf_Exception;
use ZipArchive;

class CustomMassPrintShippingLabel extends MassPrintShippingLabel
{
    /** @var DirectoryList */
    protected DirectoryList $directoryList;

    /**
     * Class Constructor
     *
     * @param DirectoryList $directoryList
     * @param Context $context
     * @param Filter $filter
     * @param FileFactory $fileFactory
     * @param LabelGenerator $labelGenerator
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        DirectoryList $directoryList,
        Context $context,
        Filter $filter,
        FileFactory $fileFactory,
        LabelGenerator $labelGenerator,
        CollectionFactory $collectionFactory
    ) {
        parent::__construct(
            $context,
            $filter,
            $fileFactory,
            $labelGenerator,
            $collectionFactory
        );

        $this->directoryList = $directoryList;
    }

    /**
     * Mass Action
     *
     * @param AbstractCollection $collection
     * @return ResultInterface|ResponseInterface
     * @throws Zend_Pdf_Exception
     * @throws LocalizedException
     */
    public function massAction(AbstractCollection $collection): ResultInterface|ResponseInterface
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
                        'rm' => true,
                    ],
                    DirectoryList::VAR_DIR,
                    'application/zip'
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
                    'type' => 'string',
                ],
                DirectoryList::VAR_DIR,
                'application/pdf'
            );
        }

        $this->messageManager->addErrorMessage(__('There are no shipping labels related to selected shipments.'));

        return $this->resultRedirectFactory->create()->setPath('sales/shipment/');
    }

    /**
     * Get label content
     *
     * @param AbstractCollection $collection
     * @return array|array[]
     */
    private function getLabelContent(AbstractCollection $collection): array
    {
        $labelsContent = [
            'pdf' => [],
            'dpl' => [],
            'epl' => [],
            'zpl' => [],
        ];

        /** @var Shipment $shipment */
        foreach ($collection as $shipment) {
            $labelContent = $shipment->getShippingLabel();
            $incrementId = $shipment->getIncrementId();

            if (!empty($labelContent)) {
                $labelFormat = $shipment->getGlsPolandShippingLabelFormat();

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

        return $labelsContent;
    }
}

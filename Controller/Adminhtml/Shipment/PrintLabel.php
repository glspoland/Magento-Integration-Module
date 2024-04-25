<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Shipment;

use Exception;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader;
use Magento\Shipping\Model\Shipping\LabelGenerator;
use Zend_Pdf;

class PrintLabel extends Action
{
    /**
     * @var ShipmentLoader
     */
    protected ShipmentLoader $shipmentLoader;

    /** @var LabelGenerator */
    protected LabelGenerator $labelGenerator;

    /** @var FileFactory */
    protected FileFactory $_fileFactory;

    /**
     * Class Constructor
     *
     * @param ShipmentLoader $shipmentLoader
     * @param Context $context
     * @param LabelGenerator $labelGenerator
     * @param FileFactory $fileFactory
     */
    public function __construct(
        ShipmentLoader $shipmentLoader,
        Context $context,
        LabelGenerator $labelGenerator,
        FileFactory $fileFactory
    ) {
        $this->shipmentLoader = $shipmentLoader;
        $this->labelGenerator = $labelGenerator;
        $this->_fileFactory = $fileFactory;

        parent::__construct($context);
    }

    /**
     * Print label for one specific shipment
     *
     * @return ResponseInterface
     */
    public function execute(): ResponseInterface
    {
        $shipmentId = $this->getRequest()->getParam('shipment_id');
        $fileName = $this->getRequest()->getParam('file_name');
        $columnName = $this->getRequest()->getParam('column_name');

        if (empty($shipmentId) || empty($fileName) || empty($columnName)) {
            return $this->_redirect(
                'adminhtml/order_shipment/view',
                ['shipment_id' => $shipmentId]
            );
        }

        try {
            $this->shipmentLoader->setShipmentId($shipmentId);
            $shipment = $this->shipmentLoader->load();
            $labelContent = $shipment->getData($columnName);

            if ($labelContent) {
                if (stripos($labelContent, '%PDF-') !== false) {
                    $pdfContent = $labelContent;
                } else {
                    $pdf = new Zend_Pdf();
                    $page = $this->labelGenerator->createPdfPageFromImageString($labelContent);

                    if (!$page) {
                        $this->messageManager->addErrorMessage(
                            __(
                                'We don\'t recognize or support the file extension in this shipment: %1.',
                                $shipment->getIncrementId()
                            )
                        );
                    }

                    $pdf->pages[] = $page;
                    $pdfContent = $pdf->render();
                }

                return $this->_fileFactory->create(
                    $fileName . '(' . $shipment->getIncrementId() . ').pdf',
                    $pdfContent,
                    DirectoryList::VAR_DIR,
                    'application/pdf'
                );
            }
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(
                __('An error occurred while creating shipping label. Message: %1', $e->getMessage())
            );
        }

        return $this->_redirect(
            'adminhtml/order_shipment/view',
            ['shipment_id' => $shipmentId]
        );
    }
}

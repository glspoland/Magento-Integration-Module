<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Order\Shipment;

use Exception;
use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Shipping\Controller\Adminhtml\Order\Shipment\PrintLabel;
use Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader;
use Magento\Shipping\Model\Shipping\LabelGenerator;
use Psr\Log\LoggerInterface;
use Zend_Pdf;

class CustomPrintLabel extends PrintLabel
{
    /**
     * Class constructor
     *
     * @param Context $context
     * @param ShipmentLoader $shipmentLoader
     * @param LabelGenerator $labelGenerator
     * @param FileFactory $fileFactory
     */
    public function __construct(
        Context $context,
        ShipmentLoader $shipmentLoader,
        LabelGenerator $labelGenerator,
        FileFactory $fileFactory
    ) {
        parent::__construct($context, $shipmentLoader, $labelGenerator, $fileFactory);

        $this->shipmentLoader = $shipmentLoader;
        $this->labelGenerator = $labelGenerator;
        $this->_fileFactory = $fileFactory;
    }

    /**
     * Print label for one specific shipment
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute(): ResponseInterface|ResultInterface
    {
        try {
            $this->shipmentLoader->setOrderId($this->getRequest()->getParam('order_id'));
            $this->shipmentLoader->setShipmentId($this->getRequest()->getParam('shipment_id'));
            $this->shipmentLoader->setShipment($this->getRequest()->getParam('shipment'));
            $this->shipmentLoader->setTracking($this->getRequest()->getParam('tracking'));
            $shipment = $this->shipmentLoader->load();
            $order = $shipment->getOrder();
            $shippingMethod = $order->getShippingMethod(true);
            $shippingCode = $shippingMethod->getCarrierCode() . '_' . $shippingMethod->getMethod();

            if (!isset(ShippingMethods::METHODS[$shippingCode])) {
                parent::execute();
            }

            $labelContent = $shipment->getShippingLabel();

            if ($labelContent) {
                $labelFormat = $shipment->getGlsPolandShippingLabelFormat();

                if ($labelFormat !== null) {
                    switch ($labelFormat) {
                        case 'roll_160x100_datamax':
                            $extension = 'dpl';
                            break;
                        case 'roll_160x100_zebra':
                        case 'roll_160x100_zebra_300':
                            $extension = 'zpl';
                            break;
                        case 'roll_160x100_zebra_epl':
                            $extension = 'epl';
                            break;
                        default:
                            $extension = 'pdf';
                            break;
                    }
                } else {
                    $extension = 'pdf';
                }

                if ($extension === 'pdf') {
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
                        'ShippingLabel(' . $shipment->getIncrementId() . ').pdf',
                        $pdfContent,
                        DirectoryList::VAR_DIR,
                        'application/pdf'
                    );
                }

                return $this->_fileFactory->create(
                    'ShippingLabel(' . $shipment->getIncrementId() . ').' . $extension,
                    $labelContent,
                    DirectoryList::VAR_DIR,
                    'application/' . $extension
                );
            }
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (Exception $e) {
            $this->_objectManager->get(LoggerInterface::class)->critical($e);
            $this->messageManager->addErrorMessage(__('An error occurred while creating shipping label.'));
        }

        return $this->resultRedirectFactory->create()
            ->setPath(
                'adminhtml/order_shipment/view',
                ['shipment_id' => $this->getRequest()->getParam('shipment_id')]
            );
    }
}

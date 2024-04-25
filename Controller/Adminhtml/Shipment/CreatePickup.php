<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Controller\Adminhtml\Shipment;

use Exception;
use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Helper\Base64Helper;
use GlsPoland\Shipping\Model\ApiHandler;
use GlsPoland\Shipping\Model\Consign;
use GlsPoland\Shipping\Model\ConsignsIDsArray;
use GlsPoland\Shipping\Model\Pod;
use GlsPoland\Shipping\Model\PodsArray;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Model\Order\Shipment;
use Magento\Sales\Model\Order\Shipment\TrackFactory;
use Magento\Sales\Model\ResourceModel\Order as OrderResource;
use Magento\Sales\Model\ResourceModel\Order\Shipment as ShipmentResource;
use Magento\Shipping\Controller\Adminhtml\Order\ShipmentLoader;
use Magento\Shipping\Model\CarrierFactory;
use Magento\Shipping\Model\Shipping\LabelGenerator;
use Netresearch\ShippingCore\Api\LabelStatus\LabelStatusManagementInterface;

class CreatePickup extends Action
{
    private const PREPARING_BOX_ID_COLUMN_NAME = 'gls_poland_preparing_box_id';
    private const PREPARING_BOX_IDENT_COLUMN_NAME = 'gls_poland_preparing_box_ident';
    private const PREPARING_BOX_CUSTOMS_DEC_COLUMN_NAME = 'gls_poland_preparing_box_customs_dec';
    private const SHIPPING_CONFIRMATION_ID_COLUMN_NAME = 'gls_poland_shipping_confirmation_id';
    private const PICKUP_IDENT_COLUMN_NAME = 'gls_poland_pickup_ident';
    private const PICKUP_PARCELS_LABELS_COLUMN_NAME = 'gls_poland_pickup_parcels_labels';
    private const PICKUP_RECEIPT_COLUMN_NAME = 'gls_poland_pickup_receipt';

    /**
     * @var ShipmentLoader
     */
    protected ShipmentLoader $shipmentLoader;

    /** @var LabelGenerator */
    protected LabelGenerator $labelGenerator;

    /** @var FileFactory */
    protected FileFactory $_fileFactory;

    /** @var ApiHandler */
    private ApiHandler $apiHandler;

    /** @var ShipmentResource */
    private ShipmentResource $shipmentResource;

    /** @var OrderResource */
    private OrderResource $orderResource;

    /** @var Base64Helper */
    private Base64Helper $base64Helper;

    /** @var Config */
    private Config $config;

    /** @var CarrierFactory */
    private CarrierFactory $carrierFactory;

    /** @var TrackFactory */
    private TrackFactory $trackFactory;

    /** @var LabelStatusManagementInterface */
    private LabelStatusManagementInterface $labelStatusManagement;

    /**
     * Class Constructor
     *
     * @param ShipmentLoader $shipmentLoader
     * @param Context $context
     * @param LabelGenerator $labelGenerator
     * @param FileFactory $fileFactory
     * @param ApiHandler $apiHandler
     * @param ShipmentResource $shipmentResource
     * @param OrderResource $orderResource
     * @param Base64Helper $base64Helper
     * @param Config $config
     * @param CarrierFactory $carrierFactory
     * @param TrackFactory $trackFactory
     * @param LabelStatusManagementInterface $labelStatusManagement
     */
    public function __construct(
        ShipmentLoader $shipmentLoader,
        Context $context,
        LabelGenerator $labelGenerator,
        FileFactory $fileFactory,
        ApiHandler $apiHandler,
        ShipmentResource $shipmentResource,
        OrderResource $orderResource,
        Base64Helper $base64Helper,
        Config $config,
        CarrierFactory $carrierFactory,
        TrackFactory $trackFactory,
        LabelStatusManagementInterface $labelStatusManagement
    ) {
        $this->shipmentLoader = $shipmentLoader;
        $this->labelGenerator = $labelGenerator;
        $this->_fileFactory = $fileFactory;
        $this->apiHandler = $apiHandler;
        $this->shipmentResource = $shipmentResource;
        $this->orderResource = $orderResource;
        $this->base64Helper = $base64Helper;
        $this->config = $config;
        $this->carrierFactory = $carrierFactory;
        $this->trackFactory = $trackFactory;
        $this->labelStatusManagement = $labelStatusManagement;

        parent::__construct($context);
    }

    /**
     * Print label for one specific shipment
     *
     * @return ResponseInterface
     * @throws LocalizedException
     */
    public function execute(): ResponseInterface
    {
        $shipmentId = $this->getRequest()->getParam('shipment_id');

        try {
            $this->shipmentLoader->setShipmentId($shipmentId);
            $shipment = $this->shipmentLoader->load();
            $order = $shipment->getOrder();
            $shippingMethod = $order->getShippingMethod(true);
            $shippingCode = $shippingMethod->getCarrierCode() . '_' . $shippingMethod->getMethod();
            $preparingBoxId = $shipment->getData(self::PREPARING_BOX_ID_COLUMN_NAME);
            $carrier = $this->carrierFactory->create($shippingMethod->getCarrierCode());
            $carrierCode = $carrier->getCarrierCode();
            $shippingMethodName = $this->config->getShippingMethodName($shippingCode);

            if (!$carrier->isShippingLabelsAvailable()) {
                $this->messageManager->addErrorMessage(
                    __('Shipping labels is not available.')
                );

                return $this->_redirect(
                    'adminhtml/order_shipment/view',
                    ['shipment_id' => $shipmentId]
                );
            }

            if ($preparingBoxId === null) {
                $this->messageManager->addErrorMessage(
                    __('Preparing Box ID is empty.')
                );

                return $this->_redirect(
                    'adminhtml/order_shipment/view',
                    ['shipment_id' => $shipmentId]
                );
            }

            /** @var int|null $shippingConfirmationId */
            $shippingConfirmationId = $this->apiHandler->createPickup(
                new ConsignsIDsArray([(int)$preparingBoxId]),
                $shippingCode
            );

            if ($shippingConfirmationId === null) {
                $this->messageManager->addErrorMessage(
                    __('Shipping Confirmation ID is empty.')
                );

                return $this->_redirect(
                    'adminhtml/order_shipment/view',
                    ['shipment_id' => $shipmentId]
                );
            }

            $shipment->setGlsPolandShippingConfirmationId((string)$shippingConfirmationId);

            /** @var string|null $pickupLabels */
            $pickupLabels = $this->apiHandler->getPickupLabels($shippingConfirmationId);

            if ($pickupLabels === null) {
                $this->messageManager->addErrorMessage(
                    __('Pickup Labels are empty.')
                );

                return $this->_redirect(
                    'adminhtml/order_shipment/view',
                    ['shipment_id' => $shipmentId]
                );
            }

            $shipment->setShippingLabel($this->base64Helper->decode($pickupLabels));

            /** @var string|null $pickupReceipt */
            $pickupReceipt = $this->apiHandler->getPickupReceipt($shippingConfirmationId);

            if (!empty($pickupReceipt)) {
                $shipment->setGlsPolandPickupReceipt($this->base64Helper->decode($pickupReceipt));
            }

            /** @var string|null $pickupIdent */
            $pickupIdent = $this->apiHandler->getPickupIdent($shippingConfirmationId);

            if (!empty($pickupIdent)) {
                $shipment->setGlsPolandPickupIdent($this->base64Helper->decode($pickupIdent));
            }

            /** @var ConsignsIDsArray|null $consignsIDsArray */
            $consignsIDsArray = $this->apiHandler->getPickupConsignIDs($shippingConfirmationId);

            if ($consignsIDsArray === null) {
                $this->messageManager->addErrorMessage(
                    __('Consigns IDs Array is empty.')
                );

                return $this->_redirect(
                    'adminhtml/order_shipment/view',
                    ['shipment_id' => $shipmentId]
                );
            }

            $pickupConsignCustomsDecArray = [];
            $pickupConsignPodsArray = [];
            $consignsArray = [];

            foreach ($consignsIDsArray->items as $consignsID) {
                /** @var string|null $pickupConsignCustomsDec */
                $pickupConsignCustomsDec = $this->apiHandler->getPickupConsignCustomsDec($consignsID);

                if ($pickupConsignCustomsDec !== null) {
                    $pickupConsignCustomsDecArray[] = $this->base64Helper->decode($pickupConsignCustomsDec);
                }

                /** @var PodsArray|null $pickupConsignPODs */
                $pickupConsignPODs = $this->apiHandler->getPickupConsignPODs($consignsID);

                if ($pickupConsignPODs !== null) {
                    foreach ($pickupConsignPODs->items as $pickupConsignPOD) {
                        /** @var POD|null $pickupConsignPOD */
                        if (!empty($pickupConsignPOD->file_pdf)) {
                            $pickupConsignPodsArray[] = $this->base64Helper->decode($pickupConsignPOD->file_pdf);
                        }
                    }
                }

                $consign = $this->apiHandler->getPickupConsign($consignsID);

                if ($consign !== null) {
                    $consignsArray[] = $consign;
                }
            }

            if (!empty($pickupConsignCustomsDecArray) && count($pickupConsignCustomsDecArray) > 0) {
                $shipment->setGlsPolandPickupConsignCustomsDec(
                    $this->labelGenerator->combineLabelsPdf($pickupConsignCustomsDecArray)->render()
                );
            }

            if (!empty($pickupConsignPodsArray) && count($pickupConsignPodsArray) > 0) {
                $shipment->setGlsPolandPickupConsignPods(
                    $this->labelGenerator->combineLabelsPdf($pickupConsignPodsArray)->render()
                );
            }

            $trackingNumbers = $this->getTrackingNumberFromConsignArray($consignsArray);

            if (!empty($trackingNumbers) && count($trackingNumbers) > 0 && !empty($trackingNumbers[0])) {
                $this->addTrackingNumbersToShipment(
                    $shipment,
                    $trackingNumbers,
                    $carrierCode,
                    $shippingMethodName
                );
            }

            if ($this->config->getOrderStatusAfterLabelPrintActive()) {
                $status = $this->config->getOrderStatusAfterLabelPrint();
                $order->setStatus($status);
                $this->orderResource->save($order);
            }

            $this->shipmentResource->save($shipment);
            $this->labelStatusManagement->setLabelStatusProcessed($shipment->getOrder());
        } catch (Exception $e) {
            if (empty($shipment)) {
                $this->shipmentLoader->setShipmentId($shipmentId);
                $shipment = $this->shipmentLoader->load();
            }

            $this->labelStatusManagement->setLabelStatusFailed($shipment->getOrder());
            $this->messageManager->addErrorMessage(
                __('An error occurred while creating Preparing Box. %1', $e->getMessage())
            );
        }

        return $this->_redirect(
            'adminhtml/order_shipment/view',
            ['shipment_id' => $shipmentId]
        );
    }

    /**
     * Get Tracking Numbers From Consign Array
     *
     * @param array $consignsArray
     * @return array
     */
    private function getTrackingNumberFromConsignArray(array $consignsArray): array
    {
        $trackingNumbers = [];

        /** @var Consign $consign */
        foreach ($consignsArray as $consign) {
            foreach ($consign->getParcels() as $parcels) {
                if (!empty($parcels->number)) {
                    $trackingNumbers[] = $parcels->number;
                } else {
                    foreach ($parcels as $parcel) {
                        if (!empty($parcel->number)) {
                            $trackingNumbers[] = $parcel->number;
                        }
                    }
                }
            }
        }

        return $trackingNumbers;
    }

    /**
     * Add Tracking Numbers To Shipment
     *
     * @param Shipment $shipment
     * @param array $trackingNumbers
     * @param string $carrierCode
     * @param string $shippingMethodName
     * @return void
     */
    private function addTrackingNumbersToShipment(
        Shipment $shipment,
        array $trackingNumbers,
        string $carrierCode,
        string $shippingMethodName
    ): void {
        foreach ($trackingNumbers as $number) {
            if (is_array($number)) {
                $this->addTrackingNumbersToShipment($shipment, $number, $carrierCode, $shippingMethodName);
            } else {
                $shipment->addTrack(
                    $this->trackFactory->create()
                        ->setNumber($number)
                        ->setCarrierCode($carrierCode)
                        ->setTitle($shippingMethodName)
                );
            }
        }
    }
}

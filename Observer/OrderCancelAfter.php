<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use GlsPoland\Shipping\Model\ApiHandler;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Api\ShipmentRepositoryInterface;
use Magento\Sales\Model\Order;

class OrderCancelAfter implements ObserverInterface
{
    private const PREPARING_BOX_ID_COLUMN_NAME = 'gls_poland_preparing_box_id';
    private const PREPARING_BOX_IDENT_COLUMN_NAME = 'gls_poland_preparing_box_ident';
    private const PREPARING_BOX_CUSTOMS_DEC_COLUMN_NAME = 'gls_poland_preparing_box_customs_dec';
    private const SHIPPING_LABEL_COLUMN_NAME = 'shipping_label';
    private const SHIPPING_CONFIRMATION_ID_COLUMN_NAME = 'gls_poland_shipping_confirmation_id';
    private const PICKUP_IDENT_COLUMN_NAME = 'gls_poland_pickup_ident';
    private const PICKUP_PARCELS_LABELS_COLUMN_NAME = 'gls_poland_pickup_parcels_labels';
    private const PICKUP_RECEIPT_COLUMN_NAME = 'gls_poland_pickup_receipt';
    private const PICKUP_CONSIGN_CUSTOMS_DEC_COLUMN_NAME = 'gls_poland_pickup_consign_customs_dec';
    private const PICKUP_CONSIGN_PODS_COLUMN_NAME = 'gls_poland_pickup_consign_pods';
    private const SHIPPING_LABEL_FORMAT_COLUMN_NAME = 'gls_poland_shipping_label_format';

    /** @var ApiHandler */
    protected ApiHandler $apiHandler;

    /** @var ShipmentRepositoryInterface */
    protected ShipmentRepositoryInterface $shipmentRepository;

    /**
     * Class constructor
     *
     * @param ApiHandler $apiHandler
     * @param ShipmentRepositoryInterface $shipmentRepository
     */
    public function __construct(ApiHandler $apiHandler, ShipmentRepositoryInterface $shipmentRepository)
    {
        $this->apiHandler = $apiHandler;
        $this->shipmentRepository = $shipmentRepository;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();
        $shipments = $order->getShipmentsCollection();

        foreach ($shipments as $shipment) {
            if ($shipment) {
                $glsPolandPreparingBoxId = $shipment->getData(self::PREPARING_BOX_ID_COLUMN_NAME);

                if ($glsPolandPreparingBoxId !== null) {
                    $result = $this->apiHandler->deletePreparingBox((int)$glsPolandPreparingBoxId);

                    if ($result !== null) {
                        $shipment->setData(self::PREPARING_BOX_ID_COLUMN_NAME, null);
                        $shipment->setData(self::PREPARING_BOX_IDENT_COLUMN_NAME, null);
                        $shipment->setData(self::PREPARING_BOX_CUSTOMS_DEC_COLUMN_NAME, null);
                        $shipment->setData(self::SHIPPING_LABEL_COLUMN_NAME, null);
                        $shipment->setData(self::SHIPPING_CONFIRMATION_ID_COLUMN_NAME, null);
                        $shipment->setData(self::PICKUP_IDENT_COLUMN_NAME, null);
                        $shipment->setData(self::PICKUP_PARCELS_LABELS_COLUMN_NAME, null);
                        $shipment->setData(self::PICKUP_RECEIPT_COLUMN_NAME, null);
                        $shipment->setData(self::PICKUP_CONSIGN_CUSTOMS_DEC_COLUMN_NAME, null);
                        $shipment->setData(self::PICKUP_CONSIGN_PODS_COLUMN_NAME, null);
                        $shipment->setData(self::SHIPPING_LABEL_FORMAT_COLUMN_NAME, null);
                        $this->shipmentRepository->save($shipment);
                    }
                }
            }
        }
    }
}

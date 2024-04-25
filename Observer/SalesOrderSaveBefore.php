<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Sales\Model\Order;
use GlsPoland\Shipping\Helper\CarrierHelper;

class SalesOrderSaveBefore implements ObserverInterface
{
    /** @var CarrierHelper */
    private CarrierHelper $carrierHelper;

    /**
     * Controller constructor
     *
     * @param CarrierHelper $carrierHelper
     */
    public function __construct(CarrierHelper $carrierHelper)
    {
        $this->carrierHelper = $carrierHelper;
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
        $shippingDescription = $order->getShippingDescription();

        if ($this->carrierHelper->isShippingCod($order) && !str_contains($shippingDescription, '(COD)')) {
            $shippingDescription .= ' (COD)';
            $order->setData('shipping_description', $shippingDescription);
        }
    }
}

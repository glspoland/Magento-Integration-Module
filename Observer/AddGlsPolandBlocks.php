<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\LayoutInterface;
use Magento\Sales\Block\Adminhtml\Order\AbstractOrder;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Shipment;
use Magento\Shipping\Block\Adminhtml\Order\Packaging;

class AddGlsPolandBlocks implements ObserverInterface
{
    /**
     * @var Registry
     */
    private Registry $coreRegistry;
    
    /** @var LayoutInterface */
    protected LayoutInterface $layout;

    /**
     * Constructor class
     *
     * @param Registry $coreRegistry
     * @param LayoutInterface $layout
     */
    public function __construct(Registry $coreRegistry, LayoutInterface $layout)
    {
        $this->coreRegistry = $coreRegistry;
        $this->layout = $layout;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $block = $observer->getEvent()->getBlock();

        if ($block instanceof Packaging && $block->getNameInLayout() === 'shipment_packaging') {
            /** @var Shipment $currentShipment */
            $currentShipment = $this->coreRegistry->registry('current_shipment');

            if ($currentShipment === null) {
                return;
            }

            /** @var string|null $shippingMethod */
            $shippingMethod = $currentShipment->getOrder()->getShippingMethod();

            if ($shippingMethod !== null && isset(ShippingMethods::METHODS[$shippingMethod])) {
                $block->setTemplate('GlsPoland_Shipping::order/packaging/popup.phtml');
            }
        }

        if ($block instanceof AbstractOrder && $block->getNameInLayout() === 'order_shipping_view') {
            /** @var Order $currentOrder */
            $currentOrder = $this->coreRegistry->registry('current_order');

            if ($currentOrder === null) {
                return;
            }

            /** @var string|null $shippingMethod */
            $shippingMethod = $currentOrder->getShippingMethod();

            if ($shippingMethod !== null &&
                isset(ShippingMethods::METHODS[$shippingMethod]['parcel']) &&
                ShippingMethods::METHODS[$shippingMethod]['parcel']) {
                $block->setTemplate('GlsPoland_Shipping::order/view/info.phtml');
            }
        }
    }
}

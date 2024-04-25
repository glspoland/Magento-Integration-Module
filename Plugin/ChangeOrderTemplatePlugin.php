<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Plugin;

use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Sales\Block\Order\Info;

class ChangeOrderTemplatePlugin
{
    /**
     * Change order template
     *
     * @param Info $subject
     * @return void
     */
    public function beforeToHtml(Info $subject): void
    {
        if ($subject->getNameInLayout() !== 'sales.order.info') {
            return;
        }

        $order = $subject->getOrder();
        $shippingMethod = $order->getShippingMethod();

        if (isset(ShippingMethods::METHODS[$shippingMethod]) && ShippingMethods::METHODS[$shippingMethod]['parcel']) {
            $subject->setTemplate('GlsPoland_Shipping::order/info.phtml');
        }
    }
}

<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use GlsPoland\Shipping\Block\Adminhtml\Shipping\GlsShipping;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\View\LayoutInterface;

class AddGlsShippingBlock implements ObserverInterface
{
    /** @var LayoutInterface */
    protected LayoutInterface $layout;

    /**
     * Constructor class
     *
     * @param LayoutInterface $layout
     */
    public function __construct(LayoutInterface $layout)
    {
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
        if ($observer->getElementName() === 'shipment_tracking') {
            $glsShippingBlock = $this->layout
                ->createBlock(GlsShipping::class)
                ->setTemplate('GlsPoland_Shipping::shipping/gls_shipping.phtml')
                ->toHtml();

            $shippingHtml = $glsShippingBlock  . "\n" . $observer->getTransport()->getOutput();
            $observer->getTransport()->setOutput($shippingHtml);
        }
    }
}

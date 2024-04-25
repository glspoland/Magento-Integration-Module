<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Order;

use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Directory\Model\CountryFactory;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\View\Element\Template\Context as TemplateContext;
use Magento\Payment\Helper\Data as PaymentHelper;
use Magento\Sales\Model\Order;
use Magento\Sales\Block\Order\Info;
use Magento\Sales\Model\Order\Address\Renderer as AddressRenderer;

class CustomInfoBlock extends Info
{
    /** @var CountryFactory */
    protected CountryFactory $countryFactory;

    /**
     *  Class constructor.
     *
     * @param CountryFactory $countryFactory
     * @param Context $context
     * @param Registry $registry
     * @param PaymentHelper $paymentHelper
     * @param AddressRenderer $addressRenderer
     * @param array $data
     */
    public function __construct(
        CountryFactory $countryFactory,
        TemplateContext $context,
        Registry $registry,
        PaymentHelper $paymentHelper,
        AddressRenderer $addressRenderer,
        array $data = []
    ) {
        parent::__construct($context, $registry, $paymentHelper, $addressRenderer, $data);

        $this->countryFactory = $countryFactory;
    }

    /**
     * Get is Gls Poland Parcel Shop Shipping
     *
     * @param Order $order
     * @return bool
     */
    public function isGlsPolandParcelShopShipping(Order $order): bool
    {
        $shippingMethod = $order->getShippingMethod();

        return isset(ShippingMethods::METHODS[$shippingMethod])
            && ShippingMethods::METHODS[$shippingMethod]['parcel'];
    }

    /**
     * Get country name by country code
     *
     * @param string $countryCode
     * @return string
     */
    public function getCountryName(string $countryCode): string
    {
        return $this->countryFactory->create()->loadByCode($countryCode)->getName();
    }
}

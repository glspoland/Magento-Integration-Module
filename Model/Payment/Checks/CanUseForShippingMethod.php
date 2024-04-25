<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model\Payment\Checks;

use Magento\Payment\Model\Checks\SpecificationInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Model\Quote;
use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Model\ShippingMethods;

class CanUseForShippingMethod implements SpecificationInterface
{
    /** @var Config */
    protected Config $config;

    /**
     * Composite constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Check whether payment method is applicable to shipping method
     *
     * @param MethodInterface $paymentMethod
     * @param Quote $quote
     * @return bool
     */
    public function isApplicable(MethodInterface $paymentMethod, Quote $quote): bool
    {
        $shippingMethodCode = $quote->getShippingAddress()->getShippingMethod();

        if (!isset(ShippingMethods::METHODS[$shippingMethodCode]['code'])) {
            return true;
        }

        $quoteValue = (float)$quote->getGrandTotal();
        $countryId = $quote->getShippingAddress()->getCountryId();
        $paymentMethodCode = $paymentMethod->getCode();
        $isCashOnDelivery = $paymentMethodCode === 'cashondelivery';
        $isOffline = $paymentMethod->isOffline();
        $isGlsParcelShop = ShippingMethods::METHODS[$shippingMethodCode]['code'] === 'gls_parcel_shop';
        $servicesMaxCOD = $this->config->getServicesMaxCOD();
        $shippingMethodCod = $this->config->getShippingMethodCod($shippingMethodCode);

        if ($countryId !== null && $countryId !== 'PL' && ($isCashOnDelivery || !$isOffline)) {
            return false;
        }

        if ($servicesMaxCOD !== null && $quoteValue > $servicesMaxCOD && ($isCashOnDelivery || !$isOffline)) {
            return false;
        }

        if ($isGlsParcelShop && ($isCashOnDelivery || !$isOffline)) {
            return false;
        }

        if (!$shippingMethodCod && ($isCashOnDelivery || !$isOffline)) {
            return false;
        }

        return true;
    }
}

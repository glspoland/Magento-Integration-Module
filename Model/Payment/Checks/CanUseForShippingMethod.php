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

        $isGlsParcelShop = ShippingMethods::METHODS[$shippingMethodCode]['code'] === 'gls_parcel_shop';
        $isCodOnly = !empty(ShippingMethods::METHODS[$shippingMethodCode]['cod_only']);
        $servicesMaxCOD = $this->config->getServicesMaxCOD();
        $shippingMethodCod = $this->config->getShippingMethodCod($shippingMethodCode);

        if ($countryId !== null && $countryId !== 'PL' && $isCashOnDelivery) {
            return false;
        }

        if ($servicesMaxCOD !== null && $quoteValue > $servicesMaxCOD && $isCashOnDelivery) {
            return false;
        }

        if ($isGlsParcelShop && $isCashOnDelivery) {
            return false;
        }

        if (!$isCodOnly && !$shippingMethodCod && $isCashOnDelivery) {
            return false;
        }

        if ($isCodOnly && !$isCashOnDelivery) {
            return false;
        }

        return true;
    }
}

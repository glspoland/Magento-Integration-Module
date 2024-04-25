<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Helper;

use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Framework\Exception\LocalizedException;
use Magento\Sales\Api\Data\OrderInterface;

class CarrierHelper
{
    /** @var Config */
    private Config $config;

    /**
     * Class constructor.
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Check if shipping method to Country is enabled
     *
     * @param string $countryId
     * @param string $ShippingMethod
     * @return bool
     */
    public function isCountryAllowed(string $countryId, string $ShippingMethod): bool
    {
        $availableCountries = $this->config->getSpecificCountry($ShippingMethod);

        return in_array($countryId, $availableCountries);
    }

    /**
     * Check if shipping method SDS to Country is Allowed
     *
     * @param string $countryId
     * @return bool
     */
    public function isCountryAllowedSDS(string $countryId): bool
    {
        $availableCountries = $this->config->getServicesCountriesSDS();

        return in_array($countryId, $availableCountries);
    }

    /**
     * Is shipping COD
     *
     * @param OrderInterface $order
     * @return bool
     */
    public function isShippingCod(OrderInterface $order): bool
    {
        try {
            $method = $order->getShippingMethod();

            if (isset(ShippingMethods::METHODS[$method]) && ShippingMethods::METHODS[$method]['parcel']) {
                return false;
            }

            $payment = $order->getPayment();

            if ($payment) {
                $paymentMethod = $payment->getMethodInstance();

                if ($paymentMethod->getCode() === 'cashondelivery') {
                    return true;
                }

                if ($paymentMethod->isOffline()) {
                    return false;
                }
            }
        } catch (LocalizedException $e) {
            return false;
        }

        return false;
    }
}

<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use GlsPoland\Shipping\Config\Config;
use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Payment\Model\MethodInterface;
use Magento\Quote\Model\Quote;

class PaymentMethodIsActiveObserver implements ObserverInterface
{
    /** @var Config */
    private Config $config;

    /**
     * Constructor class
     *
     * @param Config $config
     */
    public function __construct(
        Config $config
    ) {
        $this->config = $config;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $quote = $observer->getEvent()->getQuote();

        if ($quote instanceof Quote) {
            $shippingMethodCode = $quote->getShippingAddress()->getShippingMethod();

            if (!isset(ShippingMethods::METHODS[$shippingMethodCode]['code'])) {
                return;
            }

            /** @var MethodInterface $methodInstance */
            $methodInstance = $observer->getEvent()->getMethodInstance();

            $quoteValue = (float)$quote->getGrandTotal();
            $countryId = $quote->getShippingAddress()->getCountryId();
            $paymentMethodCode = $methodInstance->getCode();
            $isCashOnDelivery = $paymentMethodCode === 'cashondelivery';
            $isOffline = $methodInstance->isOffline();
            $isGlsParcelShop = ShippingMethods::METHODS[$shippingMethodCode]['code'] === 'gls_parcel_shop';
            $servicesMaxCOD = $this->config->getServicesMaxCOD();
            $shippingMethodCod = $this->config->getShippingMethodCod($shippingMethodCode);

            $result = $observer->getEvent()->getResult();

            if ($countryId !== null && $countryId !== 'PL' && ($isCashOnDelivery || !$isOffline)) {
                $result->setData('is_available', false);
            }

            if ($servicesMaxCOD !== null && $quoteValue > $servicesMaxCOD && ($isCashOnDelivery || !$isOffline)) {
                $result->setData('is_available', false);
            }

            if ($isGlsParcelShop && ($isCashOnDelivery || !$isOffline)) {
                $result->setData('is_available', false);
            }

            if (!$shippingMethodCod && ($isCashOnDelivery || !$isOffline)) {
                $result->setData('is_available', false);
            }
        }
    }
}

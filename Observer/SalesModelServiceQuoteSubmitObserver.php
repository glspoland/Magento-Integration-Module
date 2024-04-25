<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use GlsPoland\Shipping\Model\ShippingMethods;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Model\Order;

class SalesModelServiceQuoteSubmitObserver implements ObserverInterface
{
    public const PARCEL_SHOP_ID_COLUMN_NAME = 'gls_poland_parcel_shop_id';
    public const PARCEL_SHOP_NAME1_COLUMN_NAME = 'gls_poland_parcel_shop_name1';
    public const PARCEL_SHOP_NAME2_COLUMN_NAME = 'gls_poland_parcel_shop_name2';
    public const PARCEL_SHOP_NAME3_COLUMN_NAME = 'gls_poland_parcel_shop_name3';
    public const PARCEL_SHOP_COUNTRY_COLUMN_NAME = 'gls_poland_parcel_shop_country';
    public const PARCEL_SHOP_ZIPCODE_COLUMN_NAME = 'gls_poland_parcel_shop_zipcode';
    public const PARCEL_SHOP_CITY_COLUMN_NAME = 'gls_poland_parcel_shop_city';
    public const PARCEL_SHOP_STREET_COLUMN_NAME = 'gls_poland_parcel_shop_street';

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();

        /** @var Order $order */
        $order = $observer->getEvent()->getOrder();
        $shippingMethod = $order->getShippingMethod();

        if (isset(ShippingMethods::METHODS[$shippingMethod]) && ShippingMethods::METHODS[$shippingMethod]['parcel']) {
            $glsPolandParcelShopId = $quote->getData(self::PARCEL_SHOP_ID_COLUMN_NAME);
            $glsPolandParcelShopName1 = $quote->getData(self::PARCEL_SHOP_NAME1_COLUMN_NAME);
            $glsPolandParcelShopName2 = $quote->getData(self::PARCEL_SHOP_NAME2_COLUMN_NAME);
            $glsPolandParcelShopName3 = $quote->getData(self::PARCEL_SHOP_NAME3_COLUMN_NAME);
            $glsPolandParcelShopCountry = $quote->getData(self::PARCEL_SHOP_COUNTRY_COLUMN_NAME);
            $glsPolandParcelShopZipcode = $quote->getData(self::PARCEL_SHOP_ZIPCODE_COLUMN_NAME);
            $glsPolandParcelShopCity = $quote->getData(self::PARCEL_SHOP_CITY_COLUMN_NAME);
            $glsPolandParcelShopStreet = $quote->getData(self::PARCEL_SHOP_STREET_COLUMN_NAME);

            if (!empty($glsPolandParcelShopId)) {
                $order->setData(self::PARCEL_SHOP_ID_COLUMN_NAME, $glsPolandParcelShopId);
                $order->setData(self::PARCEL_SHOP_NAME1_COLUMN_NAME, $glsPolandParcelShopName1);
                $order->setData(self::PARCEL_SHOP_NAME2_COLUMN_NAME, $glsPolandParcelShopName2);
                $order->setData(self::PARCEL_SHOP_NAME3_COLUMN_NAME, $glsPolandParcelShopName3);
                $order->setData(self::PARCEL_SHOP_COUNTRY_COLUMN_NAME, $glsPolandParcelShopCountry);
                $order->setData(self::PARCEL_SHOP_ZIPCODE_COLUMN_NAME, $glsPolandParcelShopZipcode);
                $order->setData(self::PARCEL_SHOP_CITY_COLUMN_NAME, $glsPolandParcelShopCity);
                $order->setData(self::PARCEL_SHOP_STREET_COLUMN_NAME, $glsPolandParcelShopStreet);
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Plugin;

use Magento\Sales\Api\Data\OrderExtensionFactory;
use Magento\Sales\Api\Data\OrderInterface;
use Magento\Sales\Api\Data\OrderSearchResultInterface;
use Magento\Sales\Api\OrderRepositoryInterface;

class OrderRepositoryPlugin
{
    /** @var OrderExtensionFactory */
    protected OrderExtensionFactory $extensionFactory;

    /**
     * Class constructor
     *
     * @param OrderExtensionFactory $extensionFactory
     */
    public function __construct(OrderExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * After get order
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $resultOrder
     * @return OrderInterface
     */
    public function afterGet(OrderRepositoryInterface $subject, OrderInterface $resultOrder): OrderInterface
    {
        $this->loadExtensionAttributes($resultOrder);

        return $resultOrder;
    }

    /**
     * After get order list
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderSearchResultInterface $resultOrderList
     * @return OrderSearchResultInterface
     */
    public function afterGetList(
        OrderRepositoryInterface $subject,
        OrderSearchResultInterface $resultOrderList
    ): OrderSearchResultInterface {
        foreach ($resultOrderList->getItems() as $order) {
            $this->loadExtensionAttributes($order);
        }

        return $resultOrderList;
    }

    /**
     * Before save order
     *
     * @param OrderRepositoryInterface $subject
     * @param OrderInterface $order
     * @return OrderInterface[]
     */
    public function beforeSave(OrderRepositoryInterface $subject, OrderInterface $order): array
    {
        $extensionAttributes = $order->getExtensionAttributes() ?: $this->extensionFactory->create();

        if ($extensionAttributes !== null && $extensionAttributes->getGlsPolandParcelShopId() !== null) {
            $order->setData('gls_poland_parcel_shop_id', $extensionAttributes->getGlsPolandParcelShopId());
            $order->setData('gls_poland_parcel_shop_name1', $extensionAttributes->getGlsPolandParcelShopName1());
            $order->setData('gls_poland_parcel_shop_name2', $extensionAttributes->getGlsPolandParcelShopName2());
            $order->setData('gls_poland_parcel_shop_name3', $extensionAttributes->getGlsPolandParcelShopName3());
            $order->setData('gls_poland_parcel_shop_country', $extensionAttributes->getGlsPolandParcelShopCountry());
            $order->setData('gls_poland_parcel_shop_zipcode', $extensionAttributes->getGlsPolandParcelShopZipcode());
            $order->setData('gls_poland_parcel_shop_city', $extensionAttributes->getGlsPolandParcelShopCity());
            $order->setData('gls_poland_parcel_shop_street', $extensionAttributes->getGlsPolandParcelShopStreet());
        }

        return [$order];
    }

    /**
     * Load extension attributes
     *
     * @param OrderInterface $order
     * @return void
     */
    protected function loadExtensionAttributes(OrderInterface $order): void
    {
        $extensionAttributes = $order->getExtensionAttributes() ?: $this->extensionFactory->create();
        $glsPolandParcelShopId = $order->getData('gls_poland_parcel_shop_id');
        $glsPolandParcelShopName1 = $order->getData('gls_poland_parcel_shop_name1');
        $glsPolandParcelShopName2 = $order->getData('gls_poland_parcel_shop_name2');
        $glsPolandParcelShopName3 = $order->getData('gls_poland_parcel_shop_name3');
        $glsPolandParcelShopCountry = $order->getData('gls_poland_parcel_shop_country');
        $glsPolandParcelShopZipcode = $order->getData('gls_poland_parcel_shop_zipcode');
        $glsPolandParcelShopCity = $order->getData('gls_poland_parcel_shop_city');
        $glsPolandParcelShopStreet = $order->getData('gls_poland_parcel_shop_street');
        $extensionAttributes->setGlsPolandParcelShopId($glsPolandParcelShopId);
        $extensionAttributes->setGlsPolandParcelShopName1($glsPolandParcelShopName1);
        $extensionAttributes->setGlsPolandParcelShopName2($glsPolandParcelShopName2);
        $extensionAttributes->setGlsPolandParcelShopName3($glsPolandParcelShopName3);
        $extensionAttributes->setGlsPolandParcelShopCountry($glsPolandParcelShopCountry);
        $extensionAttributes->setGlsPolandParcelShopZipcode($glsPolandParcelShopZipcode);
        $extensionAttributes->setGlsPolandParcelShopCity($glsPolandParcelShopCity);
        $extensionAttributes->setGlsPolandParcelShopStreet($glsPolandParcelShopStreet);
        $order->setExtensionAttributes($extensionAttributes);
    }
}

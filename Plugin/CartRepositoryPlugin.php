<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Plugin;

use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartExtensionFactory;
use Magento\Quote\Api\Data\CartInterface;

class CartRepositoryPlugin
{
    /** @var CartExtensionFactory */
    protected CartExtensionFactory $extensionFactory;

    /**
     * Class constructor
     *
     * @param CartExtensionFactory $extensionFactory
     */
    public function __construct(CartExtensionFactory $extensionFactory)
    {
        $this->extensionFactory = $extensionFactory;
    }

    /**
     * After get cart
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $resultCart
     * @return CartInterface
     */
    public function afterGet(CartRepositoryInterface $subject, CartInterface $resultCart): CartInterface
    {
        $this->loadExtensionAttributes($resultCart);

        return $resultCart;
    }

    /**
     * After get cart for customer
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $resultCart
     * @return CartInterface
     */
    public function afterGetForCustomer(CartRepositoryInterface $subject, CartInterface $resultCart): CartInterface
    {
        $this->loadExtensionAttributes($resultCart);

        return $resultCart;
    }

    /**
     * After get active cart
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $resultCart
     * @return CartInterface
     */
    public function afterGetActive(CartRepositoryInterface $subject, CartInterface $resultCart): CartInterface
    {
        $this->loadExtensionAttributes($resultCart);

        return $resultCart;
    }

    /**
     * After get active cart for customer
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $resultCart
     * @return CartInterface
     */
    public function afterGetActiveForCustomer(
        CartRepositoryInterface $subject,
        CartInterface $resultCart
    ): CartInterface {
        $this->loadExtensionAttributes($resultCart);

        return $resultCart;
    }

    /**
     * Before save cart
     *
     * @param CartRepositoryInterface $subject
     * @param CartInterface $cart
     * @return CartInterface[]
     */
    public function beforeSave(CartRepositoryInterface $subject, CartInterface $cart): array
    {
        $extensionAttributes = $cart->getExtensionAttributes() ?: $this->extensionFactory->create();

        if ($extensionAttributes !== null && $extensionAttributes->getGlsPolandParcelShopId() !== null) {
            $cart->setData('gls_poland_parcel_shop_id', $extensionAttributes->getGlsPolandParcelShopId());
            $cart->setData('gls_poland_parcel_shop_name1', $extensionAttributes->getGlsPolandParcelShopName1());
            $cart->setData('gls_poland_parcel_shop_name2', $extensionAttributes->getGlsPolandParcelShopName2());
            $cart->setData('gls_poland_parcel_shop_name3', $extensionAttributes->getGlsPolandParcelShopName3());
            $cart->setData('gls_poland_parcel_shop_country', $extensionAttributes->getGlsPolandParcelShopCountry());
            $cart->setData('gls_poland_parcel_shop_zipcode', $extensionAttributes->getGlsPolandParcelShopZipcode());
            $cart->setData('gls_poland_parcel_shop_city', $extensionAttributes->getGlsPolandParcelShopCity());
            $cart->setData('gls_poland_parcel_shop_street', $extensionAttributes->getGlsPolandParcelShopStreet());
        }

        return [$cart];
    }

    /**
     * Load extension attributes
     *
     * @param CartInterface $cart
     * @return void
     */
    private function loadExtensionAttributes(CartInterface $cart): void
    {
        $extensionAttributes = $cart->getExtensionAttributes() ?: $this->extensionFactory->create();
        $glsPolandParcelShopId = $cart->getData('gls_poland_parcel_shop_id');
        $glsPolandParcelShopName1 = $cart->getData('gls_poland_parcel_shop_name1');
        $glsPolandParcelShopName2 = $cart->getData('gls_poland_parcel_shop_name2');
        $glsPolandParcelShopName3 = $cart->getData('gls_poland_parcel_shop_name3');
        $glsPolandParcelShopCountry = $cart->getData('gls_poland_parcel_shop_country');
        $glsPolandParcelShopZipcode = $cart->getData('gls_poland_parcel_shop_zipcode');
        $glsPolandParcelShopCity = $cart->getData('gls_poland_parcel_shop_city');
        $glsPolandParcelShopStreet = $cart->getData('gls_poland_parcel_shop_street');
        $extensionAttributes->setGlsPolandParcelShopId($glsPolandParcelShopId);
        $extensionAttributes->setGlsPolandParcelShopName1($glsPolandParcelShopName1);
        $extensionAttributes->setGlsPolandParcelShopName2($glsPolandParcelShopName2);
        $extensionAttributes->setGlsPolandParcelShopName3($glsPolandParcelShopName3);
        $extensionAttributes->setGlsPolandParcelShopCountry($glsPolandParcelShopCountry);
        $extensionAttributes->setGlsPolandParcelShopZipcode($glsPolandParcelShopZipcode);
        $extensionAttributes->setGlsPolandParcelShopCity($glsPolandParcelShopCity);
        $extensionAttributes->setGlsPolandParcelShopStreet($glsPolandParcelShopStreet);
        $cart->setExtensionAttributes($extensionAttributes);
    }
}

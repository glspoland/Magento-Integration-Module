<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model\Checkout;

use GlsPoland\Shipping\Model\ParcelShop;
use Magento\Quote\Api\CartRepositoryInterface;
use Magento\Quote\Api\Data\CartExtensionFactory;
use Magento\Quote\Model\Quote;

class Processor
{
    /** @var CartRepositoryInterface */
    private CartRepositoryInterface $cartRepository;

    /** @var CartExtensionFactory */
    protected CartExtensionFactory $cartExtensionFactory;

    /**
     * Class constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     * @param CartExtensionFactory $cartExtensionFactory
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        CartExtensionFactory $cartExtensionFactory
    ) {
        $this->cartRepository = $cartRepository;
        $this->cartExtensionFactory = $cartExtensionFactory;
    }

    /**
     * Save parcel shop to Quote
     *
     * @param ParcelShop $parcelShop
     * @param Quote $quote
     * @return bool
     */
    public function setParcelShop(ParcelShop $parcelShop, Quote $quote): bool
    {
        $extensionAttributes = $quote->getExtensionAttributes();

        if ($extensionAttributes === null) {
            $extensionAttributes = $this->cartExtensionFactory->create();
        }

        $extensionAttributes->setData('gls_poland_parcel_shop_id', $parcelShop->id);
        $extensionAttributes->setData('gls_poland_parcel_shop_name1', $parcelShop->name1);
        $extensionAttributes->setData('gls_poland_parcel_shop_name2', $parcelShop->name2);
        $extensionAttributes->setData('gls_poland_parcel_shop_name3', $parcelShop->name3);
        $extensionAttributes->setData('gls_poland_parcel_shop_country', $parcelShop->country);
        $extensionAttributes->setData('gls_poland_parcel_shop_zipcode', $parcelShop->zipcode);
        $extensionAttributes->setData('gls_poland_parcel_shop_city', $parcelShop->city);
        $extensionAttributes->setData('gls_poland_parcel_shop_street', $parcelShop->street);
        $quote->setExtensionAttributes($extensionAttributes);
        $this->cartRepository->save($quote);

        return true;
    }
}

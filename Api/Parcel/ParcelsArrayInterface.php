<?php

namespace GlsPoland\Shipping\Api\Parcel;

interface ParcelsArrayInterface
{
    /**
     * Get items
     *
     * @return ParcelInterface[]
     */
    public function getItems(): array;

    /**
     * Set items
     *
     * @param ParcelInterface[] $items
     * @return void
     */
    public function setItems(array $items): void;
}

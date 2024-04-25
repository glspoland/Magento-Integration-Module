<?php

namespace GlsPoland\Shipping\Api\Pickup;

interface PickupsIDsArrayInterface
{
    /**
     * Get items.
     *
     * @return PickupInterface[]
     */
    public function getItems(): array;

    /**
     * Set items.
     *
     * @param PickupInterface[] $items
     * @return void
     */
    public function setItems(array $items): void;
}

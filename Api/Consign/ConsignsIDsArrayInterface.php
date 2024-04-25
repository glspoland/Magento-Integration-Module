<?php

namespace GlsPoland\Shipping\Api\Consign;

interface ConsignsIDsArrayInterface
{
    /**
     * Get items.
     *
     * @return int[]
     */
    public function getItems(): array;

    /**
     * Set items.
     *
     * @param int[] $items
     * @return void
     */
    public function setItems(array $items): void;
}

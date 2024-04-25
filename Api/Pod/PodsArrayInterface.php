<?php

namespace GlsPoland\Shipping\Api\Pod;

interface PodsArrayInterface
{
    /**
     * Get items.
     *
     * @return PodInterface[]
     */
    public function getItems(): array;

    /**
     * Set items.
     *
     * @param PodInterface[] $items
     * @return void
     */
    public function setItems(array $items): void;
}

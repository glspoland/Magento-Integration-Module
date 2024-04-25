<?php

namespace GlsPoland\Shipping\Api\Label;

interface LabelsArrayInterface
{
    /**
     * Get items.
     *
     * @return LabelInterface[]
     */
    public function getItems(): array;

    /**
     * Set items.
     *
     * @param LabelInterface[] $items
     * @return void
     */
    public function setItems(array $items): void;
}

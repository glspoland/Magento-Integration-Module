<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Consign\ConsignsIDsArrayInterface;

class ConsignsIDsArray implements ConsignsIDsArrayInterface
{
    /** @var int[] */
    public array $items;

    /**
     * Class constructor.
     *
     * @param int[] $items
     */
    public function __construct(array $items)
    {
        $this->setItems($items);
    }

    /**
     * Get items.
     *
     * @return int[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Set items.
     *
     * @param int[] $items
     * @return void
     */
    public function setItems(array $items): void
    {
        foreach ($items as $item) {
            $this->addToItems($item);
        }
    }

    /**
     * Add to items.
     *
     * @param int $item
     * @return void
     */
    public function addToItems(int $item): void
    {
        $this->items[] = $item;
    }
}

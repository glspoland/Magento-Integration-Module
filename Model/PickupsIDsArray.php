<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Pickup\PickupsIDsArrayInterface;

class PickupsIDsArray implements PickupsIDsArrayInterface
{
    /** @var Pickup[] */
    public array $items;

    /**
     * Class constructor.
     *
     * @param Pickup[] $items
     */
    public function __construct(array $items)
    {
        $this->setItems($items);
    }

    /**
     * Get items.
     *
     * @return Pickup[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Set items.
     *
     * @param Pickup[] $items
     * @return void
     */
    public function setItems(array $items): void
    {
        foreach ($items as $item) {
            $this->addToItems(new Pickup($item->desc, $item->quantity, $item->weight, $item->datetime));
        }
    }

    /**
     * Add to items.
     *
     * @param Pickup $item
     * @return void
     */
    public function addToItems(Pickup $item): void
    {
        $this->items[] = $item;
    }
}

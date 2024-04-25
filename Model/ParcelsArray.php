<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Parcel\ParcelsArrayInterface;

class ParcelsArray implements ParcelsArrayInterface
{
    /** @var Parcel[] */
    public array $items;

    /**
     * Class constructor.
     *
     * @param Parcel[] $items
     */
    public function __construct(array $items)
    {
        $this->setItems($items);
    }

    /**
     * Get items.
     *
     * @return Parcel[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * Set items.
     *
     * @param array $items
     * @return void
     */
    public function setItems(array $items): void
    {
        foreach ($items as $item) {
            $this->addToItems(
                new Parcel(
                    $item->number,
                    $item->reference,
                    $item->weight,
                    $item->srv_bool,
                    $item->srv_ade
                )
            );
        }
    }

    /**
     * Add to items.
     *
     * @param Parcel $item
     * @return void
     */
    public function addToItems(Parcel $item): void
    {
        $this->items[] = $item;
    }
}

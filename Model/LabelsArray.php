<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Label\LabelsArrayInterface;

class LabelsArray implements LabelsArrayInterface
{
    /** @var Label[] */
    public array $items;

    /**
     * Class constructor.
     *
     * @param Label[] $items
     */
    public function __construct(array $items)
    {
        $this->setItems($items);
    }

    /**
     * Get items.
     *
     * @return Label[]
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
                new Label(
                    $item->number,
                    $item->file
                )
            );
        }
    }

    /**
     * Add to items.
     *
     * @param Label $item
     * @return void
     */
    public function addToItems(Label $item): void
    {
        $this->items[] = $item;
    }
}

<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Pod\PodsArrayInterface;

class PodsArray implements PodsArrayInterface
{
    /** @var Pod[] */
    public array $items;

    /**
     * Class constructor.
     *
     * @param Pod[] $items
     */
    public function __construct(array $items)
    {
        $this->setItems($items);
    }

    /**
     * Get items.
     *
     * @return Pod[]
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
                new Pod(
                    $item->number,
                    $item->file_pdf
                )
            );
        }
    }

    /**
     * Add to items.
     *
     * @param Pod $item
     * @return void
     */
    public function addToItems(Pod $item): void
    {
        $this->items[] = $item;
    }
}

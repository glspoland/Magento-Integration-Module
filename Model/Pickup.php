<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Pickup\PickupInterface;

class Pickup implements PickupInterface
{
    /** @var string */
    public string $desc;

    /** @var int */
    public int $quantity;

    /** @var float */
    public float $weight;

    /** @var string */
    public string $datetime;

    /**
     * Constructor method.
     *
     * @param string $desc
     * @param int $quantity
     * @param float $weight
     * @param string $datetime
     */
    public function __construct(string $desc, int $quantity, float $weight, string $datetime)
    {
        $this->setDesc($desc);
        $this->setQuantity($quantity);
        $this->setWeight($weight);
        $this->setDatetime($datetime);
    }

    /**
     * Get desc.
     *
     * @return string
     */
    public function getDesc(): string
    {
        return $this->desc;
    }

    /**
     * Set desc.
     *
     * @param string $desc
     * @return void
     */
    public function setDesc(string $desc): void
    {
        $this->desc = $desc;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     * @return void
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * Get weight.
     *
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * Set weight.
     *
     * @param float $weight
     * @return void
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * Get datetime.
     *
     * @return string
     */
    public function getDatetime(): string
    {
        return $this->datetime;
    }

    /**
     * Set datetime.
     *
     * @param string $datetime
     * @return void
     */
    public function setDatetime(string $datetime): void
    {
        $this->datetime = $datetime;
    }
}

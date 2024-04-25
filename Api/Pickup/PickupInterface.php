<?php

namespace GlsPoland\Shipping\Api\Pickup;

interface PickupInterface
{
    /**
     * Get desc.
     *
     * @return string
     */
    public function getDesc(): string;

    /**
     * Set desc.
     *
     * @param string $desc
     * @return void
     */
    public function setDesc(string $desc): void;

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity(): int;

    /**
     * Set quantity.
     *
     * @param int $quantity
     * @return void
     */
    public function setQuantity(int $quantity): void;

    /**
     * Get weight.
     *
     * @return float
     */
    public function getWeight(): float;

    /**
     * Set weight.
     *
     * @param float $weight
     * @return void
     */
    public function setWeight(float $weight): void;

    /**
     * Get datetime.
     *
     * @return string
     */
    public function getDatetime(): string;

    /**
     * Set datetime.
     *
     * @param string $datetime
     * @return void
     */
    public function setDatetime(string $datetime): void;
}

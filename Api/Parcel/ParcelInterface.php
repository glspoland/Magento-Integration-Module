<?php

namespace GlsPoland\Shipping\Api\Parcel;

use GlsPoland\Shipping\Model\ServiceBOOL;

interface ParcelInterface
{
    /**
     * Get number
     *
     * @return string
     */
    public function getNumber(): string;

    /**
     * Set number
     *
     * @param string $number
     * @return void
     */
    public function setNumber(string $number): void;

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference(): string;

    /**
     * Set reference
     *
     * @param string $reference
     * @return void
     */
    public function setReference(string $reference): void;

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight(): float;

    /**
     * Set weight
     *
     * @param float $weight
     * @return void
     */
    public function setWeight(float $weight): void;

    /**
     * Get srv_bool
     *
     * @return ServiceBOOL
     */
    public function getSrvBool(): ServiceBOOL;

    /**
     * Set srv_bool
     *
     * @param ServiceBOOL $srv_bool
     * @return void
     */
    public function setSrvBool(ServiceBOOL $srv_bool): void;

    /**
     * Get srv_ade
     *
     * @return string
     */
    public function getSrvAde(): string;

    /**
     * Set srv_ade
     *
     * @param string $srv_ade
     * @return void
     */
    public function setSrvAde(string $srv_ade): void;
}

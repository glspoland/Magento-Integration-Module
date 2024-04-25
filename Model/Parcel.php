<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Parcel\ParcelInterface;

class Parcel implements ParcelInterface
{
    /** @var string|null */
    public ?string $number;

    /** @var string */
    public string $reference;

    /** @var float */
    public float $weight;

    /** @var ServiceBOOL */
    public ServiceBOOL $srv_bool;

    /** @var string */
    public string $srv_ade;

    /**
     * Constructor method.
     *
     * @param string $number
     * @param string $reference
     * @param float $weight
     * @param ServiceBOOL $srv_bool
     * @param string $srv_ade
     */
    public function __construct(
        string $number,
        string $reference,
        float $weight,
        ServiceBOOL $srv_bool,
        string $srv_ade
    ) {
        $this->setNumber($number);
        $this->setReference($reference);
        $this->setWeight($weight);
        $this->setSrvBool($srv_bool);
        $this->setSrvAde($srv_ade);
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Set number
     *
     * @param string|null $number
     * @return void
     */
    public function setNumber(string $number = null): void
    {
        $this->number = $number;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * Set reference
     *
     * @param string $reference
     * @return void
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * Set weight
     *
     * @param float $weight
     * @return void
     */
    public function setWeight(float $weight): void
    {
        $this->weight = $weight;
    }

    /**
     * Get srv_bool
     *
     * @return ServiceBOOL
     */
    public function getSrvBool(): ServiceBOOL
    {
        return $this->srv_bool;
    }

    /**
     * Set srv_bool
     *
     * @param ServiceBOOL $srv_bool
     * @return void
     */
    public function setSrvBool(ServiceBOOL $srv_bool): void
    {
        $this->srv_bool = $srv_bool;
    }

    /**
     * Get srv_ade
     *
     * @return string
     */
    public function getSrvAde(): string
    {
        return $this->srv_ade;
    }

    /**
     * Set srv_ade
     *
     * @param string $srv_ade
     * @return void
     */
    public function setSrvAde(string $srv_ade): void
    {
        $this->srv_ade = $srv_ade;
    }
}

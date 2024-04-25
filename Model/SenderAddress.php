<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

class SenderAddress
{
    /** @var string $name1 */
    public string $name1;

    /** @var string $name2 */
    public string $name2;

    /** @var string $name3 */
    public string $name3;

    /** @var string $country */
    public string $country;

    /** @var string $zipcode */
    public string $zipcode;

    /** @var string $city */
    public string $city;

    /** @var string $street */
    public string $street;

    /**
     * Constructor method for cSenderAddress
     *
     * @param string|null $name1
     * @param string|null $name2
     * @param string|null $name3
     * @param string|null $country
     * @param string|null $zipcode
     * @param string|null $city
     * @param string|null $street
     */
    public function __construct(
        string $name1 = null,
        string $name2 = null,
        string $name3 = null,
        string $country = null,
        string $zipcode = null,
        string $city = null,
        string $street = null
    ) {
        $this->setName1($name1);
        $this->setName2($name2);
        $this->setName3($name3);
        $this->setCountry($country);
        $this->setZipcode($zipcode);
        $this->setCity($city);
        $this->setStreet($street);
    }

    /**
     * Get Name 1.
     *
     * @return string
     */
    public function getName1(): string
    {
        return $this->name1;
    }

    /**
     * Set Name 1.
     *
     * @param string|null $name1
     * @return void
     */
    public function setName1(string $name1 = null): void
    {
        $this->name1 = $name1;
    }

    /**
     * Get Name 2
     *
     * @return string
     */
    public function getName2(): string
    {
        return $this->name2;
    }

    /**
     * Set Name 2
     *
     * @param string|null $name2
     * @return void
     */
    public function setName2(string $name2 = null): void
    {
        $this->name2 = $name2;
    }

    /**
     * Get Name 3
     *
     * @return string
     */
    public function getName3(): string
    {
        return $this->name3;
    }

    /**
     * Set Name 3
     *
     * @param string|null $name3
     * @return void
     */
    public function setName3(string $name3 = null): void
    {
        $this->name3 = $name3;
    }

    /**
     * Get country value
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Set Country
     *
     * @param string|null $country
     * @return void
     */
    public function setCountry(string $country = null): void
    {
        $this->country = $country;
    }

    /**
     * Get Zipcode.
     *
     * @return string
     */
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * Set Zipcode.
     *
     * @param string|null $zipcode
     * @return void
     */
    public function setZipcode(string $zipcode = null): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Get city value
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Set City value.
     *
     * @param string|null $city
     * @return void
     */
    public function setCity(string $city = null): void
    {
        $this->city = $city;
    }

    /**
     * Get Street.
     *
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * Set Street.
     *
     * @param string|null $street
     * @return void
     */
    public function setStreet(string $street = null): void
    {
        $this->street = $street;
    }
}

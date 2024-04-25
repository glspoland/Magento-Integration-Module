<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

class ServiceIDENT
{
    /** @var string */
    public string $name;

    /** @var string */
    public string $country;

    /** @var string */
    public string $zipcode;

    /** @var string */
    public string $city;

    /** @var string */
    public string $street;

    /** @var string|null */
    public ?string $date_birth;

    /** @var string|null */
    public ?string $identity;

    /** @var int|null */
    public ?int $ident_doctype;

    /** @var string|null */
    public ?string $nation;

    /** @var string|null */
    public ?string $national_idnum;

    /** @var int|null */
    public ?int $spages;

    /** @var int|null */
    public ?int $ssign;

    /** @var int|null */
    public ?int $sdealsend;

    /** @var int|null */
    public ?int $sdealrec;

    /**
     * Constructor method for cServiceIDENT
     * @param string $name
     * @param string $country
     * @param string $zipcode
     * @param string $city
     * @param string $street
     * @param string|null $date_birth
     * @param string|null $identity
     * @param int|null $ident_doctype
     * @param string|null $nation
     * @param string|null $national_idnum
     * @param int|null $spages
     * @param int|null $ssign
     * @param int|null $sdealsend
     * @param int|null $sdealrec
     */
    public function __construct(
        string $name,
        string $country,
        string $zipcode,
        string $city,
        string $street,
        string $date_birth = null,
        string $identity = null,
        int $ident_doctype = null,
        string $nation = null,
        string $national_idnum = null,
        int $spages = null,
        int $ssign = null,
        int $sdealsend = null,
        int $sdealrec = null
    ) {
        $this->setName($name);
        $this->setCountry($country);
        $this->setZipcode($zipcode);
        $this->setCity($city);
        $this->setStreet($street);
        $this->setDateBirth($date_birth);
        $this->setIdentity($identity);
        $this->setIdentDoctype($ident_doctype);
        $this->setNation($nation);
        $this->setNationalIdnum($national_idnum);
        $this->setSpages($spages);
        $this->setSsign($ssign);
        $this->setSdealsend($sdealsend);
        $this->setSdealrec($sdealrec);
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get Country
     *
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * Set Country.
     *
     * @param string $country
     * @return void
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * Get Zip code.
     *
     * @return string
     */
    public function getZipcode(): string
    {
        return $this->zipcode;
    }

    /**
     * Set Zip code.
     *
     * @param string $zipcode
     * @return void
     */
    public function setZipcode(string $zipcode): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Get City.
     *
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * Set City
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city): void
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
     * @param string $street
     * @return void
     */
    public function setStreet(string $street): void
    {
        $this->street = $street;
    }

    /**
     * Get Date of birth.
     *
     * @return string|null
     */
    public function getDateBirth(): ?string
    {
        return $this->date_birth;
    }

    /**
     * Set Date of birth.
     *
     * @param string|null $date_birth
     * @return void
     */
    public function setDateBirth(string $date_birth = null): void
    {
        $this->date_birth = $date_birth;
    }

    /**
     * Get Identity.
     *
     * @return string|null
     */
    public function getIdentity(): ?string
    {
        return $this->identity;
    }

    /**
     * Set Identity.
     *
     * @param string|null $identity
     * @return void
     */
    public function setIdentity(string $identity = null): void
    {
        $this->identity = $identity;
    }

    /**
     * Get Identity doc type.
     *
     * @return int|null
     */
    public function getIdentDoctype(): ?int
    {
        return $this->ident_doctype;
    }

    /**
     * Set Identity doc type.
     *
     * @param int|null $ident_doctype
     * @return void
     */
    public function setIdentDoctype(int $ident_doctype = null): void
    {
        $this->ident_doctype = $ident_doctype;
    }

    /**
     * Get Nation
     *
     * @return string|null
     */
    public function getNation(): ?string
    {
        return $this->nation;
    }

    /**
     * Set Natiom
     *
     * @param string|null $nation
     * @return void
     */
    public function setNation(string $nation = null): void
    {
        $this->nation = $nation;
    }

    /**
     * Get National id number.
     *
     * @return string|null
     */
    public function getNationalIdnum(): ?string
    {
        return $this->national_idnum;
    }

    /**
     * Set National id number.
     *
     * @param string|null $national_idnum
     * @return void
     */
    public function setNationalIdnum(string $national_idnum = null): void
    {
        $this->national_idnum = $national_idnum;
    }

    /**
     * Get Pages.
     *
     * @return int|null
     */
    public function getSpages(): ?int
    {
        return $this->spages;
    }

    /**
     * Set pages.
     *
     * @param int|null $spages
     * @return void
     */
    public function setSpages(int $spages = null): void
    {
        $this->spages = $spages;
    }

    /**
     * Get sign
     *
     * @return int|null
     */
    public function getSsign(): ?int
    {
        return $this->ssign;
    }

    /**
     * Set Sign
     *
     * @param int|null $ssign
     * @return void
     */
    public function setSsign(int $ssign = null): void
    {
        $this->ssign = $ssign;
    }

    /**
     * Get Deal
     *
     * @return int|null
     */
    public function getSdealsend(): ?int
    {
        return $this->sdealsend;
    }

    /**
     * Set deal
     *
     * @param int|null $sdealsend
     * @return void
     */
    public function setSdealsend(int $sdealsend = null): void
    {
        $this->sdealsend = $sdealsend;
    }

    /**
     * Get Dealer
     *
     * @return int|null
     */
    public function getSdealrec(): ?int
    {
        return $this->sdealrec;
    }

    /**
     * Set Dealer.
     *
     * @param int|null $sdealrec
     * @return void
     */
    public function setSdealrec(int $sdealrec = null): void
    {
        $this->sdealrec = $sdealrec;
    }
}

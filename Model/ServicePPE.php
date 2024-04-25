<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

class ServicePPE
{
    /** @var string */
    public string $sname1;

    /** @var string|null */
    public ?string $sname2;

    /** @var string|null */
    public ?string $sname3;

    /** @var string */
    public string $scountry;

    /** @var string */
    public string $szipcode;

    /** @var string */
    public string $scity;

    /** @var string */
    public string $sstreet;

    /** @var string|null */
    public ?string $sphone;

    /** @var string|null */
    public ?string $scontact;

    /** @var string */
    public string $rname1;

    /** @var string|null */
    public ?string $rname2;

    /** @var string|null */
    public ?string $rname3;

    /** @var string */
    public string $rcountry;

    /** @var string */
    public string $rzipcode;

    /** @var string */
    public string $rcity;

    /** @var string */
    public string $rstreet;

    /** @var string|null */
    public ?string $rphone;

    /** @var string|null */
    public ?string $rcontact;

    /** @var string|null */
    public ?string $references;

    /** @var float */
    public float $weight;

    /**
     * Constructor method for Service PPE
     *
     * @param string $sname1
     * @param string $scountry
     * @param string $szipcode
     * @param string $scity
     * @param string $sstreet
     * @param string $rname1
     * @param string $rcountry
     * @param string $rzipcode
     * @param string $rcity
     * @param string $rstreet
     * @param float $weight
     * @param string|null $sname2
     * @param string|null $sname3
     * @param string|null $sphone
     * @param string|null $scontact
     * @param string|null $rname2
     * @param string|null $rname3
     * @param string|null $rphone
     * @param string|null $rcontact
     * @param string|null $references
     */
    public function __construct(
        string $sname1,
        string $scountry,
        string $szipcode,
        string $scity,
        string $sstreet,
        string $rname1,
        string $rcountry,
        string $rzipcode,
        string $rcity,
        string $rstreet,
        float $weight,
        string $sname2 = null,
        string $sname3 = null,
        string $sphone = null,
        string $scontact = null,
        string $rname2 = null,
        string $rname3 = null,
        string $rphone = null,
        string $rcontact = null,
        string $references = null
    ) {
        $this->setSname1($sname1);
        $this->setSname2($sname2);
        $this->setSname3($sname3);
        $this->setScountry($scountry);
        $this->setSzipcode($szipcode);
        $this->setScity($scity);
        $this->setSstreet($sstreet);
        $this->setSphone($sphone);
        $this->setScontact($scontact);
        $this->setRname1($rname1);
        $this->setRname2($rname2);
        $this->setRname3($rname3);
        $this->setRcountry($rcountry);
        $this->setRzipcode($rzipcode);
        $this->setRcity($rcity);
        $this->setRstreet($rstreet);
        $this->setRphone($rphone);
        $this->setRcontact($rcontact);
        $this->setReferences($references);
        $this->setWeight($weight);
    }

    /**
     * Get sender name 1
     *
     * @return string
     */
    public function getSname1(): string
    {
        return $this->sname1;
    }

    /**
     * Set sender name 1
     *
     * @param string $sname1
     * @return void
     */
    public function setSname1(string $sname1): void
    {
        $this->sname1 = $sname1;
    }

    /**
     * Get sender name 2
     *
     * @return string|null
     */
    public function getSname2(): ?string
    {
        return $this->sname2;
    }

    /**
     * Set sender name 2
     *
     * @param string|null $sname2
     * @return void
     */
    public function setSname2(?string $sname2): void
    {
        $this->sname2 = $sname2;
    }

    /**
     * Get sender name 3
     *
     * @return string|null
     */
    public function getSname3(): ?string
    {
        return $this->sname3;
    }

    /**
     * Set sender name 3
     *
     * @param string|null $sname3
     * @return void
     */
    public function setSname3(?string $sname3): void
    {
        $this->sname3 = $sname3;
    }

    /**
     * Get sender country
     *
     * @return string
     */
    public function getScountry(): string
    {
        return $this->scountry;
    }

    /**
     * Set sender country
     *
     * @param string $scountry
     * @return void
     */
    public function setScountry(string $scountry): void
    {
        $this->scountry = $scountry;
    }

    /**
     * Get sender zipcode
     *
     * @return string
     */
    public function getSzipcode(): string
    {
        return $this->szipcode;
    }

    /**
     * Set sender zipcode
     *
     * @param string $szipcode
     * @return void
     */
    public function setSzipcode(string $szipcode): void
    {
        $this->szipcode = $szipcode;
    }

    /**
     * Get sender city
     *
     * @return string
     */
    public function getScity(): string
    {
        return $this->scity;
    }

    /**
     * Set sender city
     *
     * @param string $scity
     * @return void
     */
    public function setScity(string $scity): void
    {
        $this->scity = $scity;
    }

    /**
     * Get sender street
     *
     * @return string
     */
    public function getSstreet(): string
    {
        return $this->sstreet;
    }

    /**
     * Set sender street
     *
     * @param string $sstreet
     * @return void
     */
    public function setSstreet(string $sstreet): void
    {
        $this->sstreet = $sstreet;
    }

    /**
     * Get sender phone
     *
     * @return string|null
     */
    public function getSphone(): ?string
    {
        return $this->sphone;
    }

    /**
     * Set sender phone
     *
     * @param string|null $sphone
     * @return void
     */
    public function setSphone(?string $sphone): void
    {
        $this->sphone = $sphone;
    }

    /**
     * Get sender contact
     *
     * @return string|null
     */
    public function getScontact(): ?string
    {
        return $this->scontact;
    }

    /**
     * Set sender contact
     *
     * @param string|null $scontact
     * @return void
     */
    public function setScontact(?string $scontact): void
    {
        $this->scontact = $scontact;
    }

    /**
     * Get receiver name 1
     *
     * @return string
     */
    public function getRname1(): string
    {
        return $this->rname1;
    }

    /**
     * Set receiver name 1
     *
     * @param string $rname1
     * @return void
     */
    public function setRname1(string $rname1): void
    {
        $this->rname1 = $rname1;
    }

    /**
     * Get receiver name 2
     *
     * @return string|null
     */
    public function getRname2(): ?string
    {
        return $this->rname2;
    }

    /**
     * Set receiver name 2
     *
     * @param string|null $rname2
     * @return void
     */
    public function setRname2(?string $rname2): void
    {
        $this->rname2 = $rname2;
    }

    /**
     * Get receiver name 3
     *
     * @return string|null
     */
    public function getRname3(): ?string
    {
        return $this->rname3;
    }

    /**
     * Set receiver name 3
     *
     * @param string|null $rname3
     * @return void
     */
    public function setRname3(?string $rname3): void
    {
        $this->rname3 = $rname3;
    }

    /**
     * Get receiver country
     *
     * @return string
     */
    public function getRcountry(): string
    {
        return $this->rcountry;
    }

    /**
     * Set receiver country
     *
     * @param string $rcountry
     * @return void
     */
    public function setRcountry(string $rcountry): void
    {
        $this->rcountry = $rcountry;
    }

    /**
     * Get receiver zipcode
     *
     * @return string
     */
    public function getRzipcode(): string
    {
        return $this->rzipcode;
    }

    /**
     * Set receiver zipcode
     *
     * @param string $rzipcode
     * @return void
     */
    public function setRzipcode(string $rzipcode): void
    {
        $this->rzipcode = $rzipcode;
    }

    /**
     * Get receiver city
     *
     * @return string
     */
    public function getRcity(): string
    {
        return $this->rcity;
    }

    /**
     * Set receiver city
     *
     * @param string $rcity
     * @return void
     */
    public function setRcity(string $rcity): void
    {
        $this->rcity = $rcity;
    }

    /**
     * Get receiver street
     *
     * @return string
     */
    public function getRstreet(): string
    {
        return $this->rstreet;
    }

    /**
     * Set receiver street
     *
     * @param string $rstreet
     * @return void
     */
    public function setRstreet(string $rstreet): void
    {
        $this->rstreet = $rstreet;
    }

    /**
     * Get receiver phone
     *
     * @return string|null
     */
    public function getRphone(): ?string
    {
        return $this->rphone;
    }

    /**
     * Set receiver phone
     *
     * @param string|null $rphone
     * @return void
     */
    public function setRphone(?string $rphone): void
    {
        $this->rphone = $rphone;
    }

    /**
     * Get receiver contact
     *
     * @return string|null
     */
    public function getRcontact(): ?string
    {
        return $this->rcontact;
    }

    /**
     * Set receiver contact
     *
     * @param string|null $rcontact
     * @return void
     */
    public function setRcontact(?string $rcontact): void
    {
        $this->rcontact = $rcontact;
    }

    /**
     * Get references
     *
     * @return string|null
     */
    public function getReferences(): ?string
    {
        return $this->references;
    }

    /**
     * Set references
     *
     * @param string|null $references
     * @return void
     */
    public function setReferences(?string $references): void
    {
        $this->references = $references;
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
}

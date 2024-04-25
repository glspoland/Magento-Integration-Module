<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

class ServiceSDS
{
    /** @var string */
    public string $id;

    /** @var string|null */
    public ?string $name1;

    /** @var string|null */
    public ?string $name2;

    /** @var string|null */
    public ?string $name3;

    /** @var string|null */
    public ?string $country;

    /** @var string|null */
    public ?string $zipcode;

    /** @var string|null */
    public ?string $city;

    /** @var string|null */
    public ?string $street;

    /** @var string|null */
    public ?string $phone;

    /** @var string|null */
    public ?string $email;

    /** @var float|null */
    public ?float $gps_lati;

    /** @var float|null */
    public ?float $gps_long;

    /** @var string|null */
    public ?string $mon_open;

    /** @var string|null */
    public ?string $mon_close;

    /** @var string|null */
    public ?string $tue_open;

    /** @var string|null */
    public ?string $tue_close;

    /** @var string|null */
    public ?string $wed_open;

    /** @var string|null */
    public ?string $wed_close;

    /** @var string|null */
    public ?string $thu_open;

    /** @var string|null */
    public ?string $thu_close;

    /** @var string|null */
    public ?string $fri_open;

    /** @var string|null */
    public ?string $fri_close;

    /** @var string|null */
    public ?string $sat_open;

    /** @var string|null */
    public ?string $sat_close;

    /** @var string|null */
    public ?string $sun_open;

    /** @var string|null */
    public ?string $sun_close;

    /**
     * Constructor method for ServiceSDS
     *
     * @param string $id
     * @param string|null $name1
     * @param string|null $name2
     * @param string|null $name3
     * @param string|null $country
     * @param string|null $zipcode
     * @param string|null $city
     * @param string|null $street
     * @param string|null $phone
     * @param string|null $email
     * @param float|null $gps_lati
     * @param float|null $gps_long
     * @param string|null $mon_open
     * @param string|null $mon_close
     * @param string|null $tue_open
     * @param string|null $tue_close
     * @param string|null $wed_open
     * @param string|null $wed_close
     * @param string|null $thu_open
     * @param string|null $thu_close
     * @param string|null $fri_open
     * @param string|null $fri_close
     * @param string|null $sat_open
     * @param string|null $sat_close
     * @param string|null $sun_open
     * @param string|null $sun_close
     */
    public function __construct(
        string $id,
        string $name1 = null,
        string $name2 = null,
        string $name3 = null,
        string $country = null,
        string $zipcode = null,
        string $city = null,
        string $street = null,
        string $phone = null,
        string $email = null,
        float $gps_lati = null,
        float $gps_long = null,
        string $mon_open = null,
        string $mon_close = null,
        string $tue_open = null,
        string $tue_close = null,
        string $wed_open = null,
        string $wed_close = null,
        string $thu_open = null,
        string $thu_close = null,
        string $fri_open = null,
        string $fri_close = null,
        string $sat_open = null,
        string $sat_close = null,
        string $sun_open = null,
        string $sun_close = null
    ) {
        $this->setId($id);
        $this->setName1($name1);
        $this->setName2($name2);
        $this->setName3($name3);
        $this->setCountry($country);
        $this->setZipcode($zipcode);
        $this->setCity($city);
        $this->setStreet($street);
        $this->setPhone($phone);
        $this->setEmail($email);
        $this->setGpsLati($gps_lati);
        $this->setGpsLong($gps_long);
        $this->setMonOpen($mon_open);
        $this->setMonClose($mon_close);
        $this->setTueOpen($tue_open);
        $this->setTueClose($tue_close);
        $this->setWedOpen($wed_open);
        $this->setWedClose($wed_close);
        $this->setThuOpen($thu_open);
        $this->setThuClose($thu_close);
        $this->setFriOpen($fri_open);
        $this->setFriClose($fri_close);
        $this->setSatOpen($sat_open);
        $this->setSatClose($sat_close);
        $this->setSunOpen($sun_open);
        $this->setSunClose($sun_close);
    }

    /**
     * Get Id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param string $id
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Get Name 1
     *
     * @return string|null
     */
    public function getName1(): ?string
    {
        return $this->name1;
    }

    /**
     * Set Name 1
     *
     * @param string|null $name1
     * @return void
     */
    public function setName1(string $name1 = null): void
    {
        $this->name1 = $name1;
    }

    /**
     * Get name 2
     *
     * @return string|null
     */
    public function getName2(): ?string
    {
        return $this->name2;
    }

    /**
     * Set name 2.
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
     * @return string|null
     */
    public function getName3(): ?string
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
     * Get Country
     *
     * @return string|null
     */
    public function getCountry(): ?string
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
     * Get Zip code
     *
     * @return string|null
     */
    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    /**
     * Set zip code
     *
     * @param string|null $zipcode
     * @return void
     */
    public function setZipcode(string $zipcode = null): void
    {
        $this->zipcode = $zipcode;
    }

    /**
     * Get City
     *
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set City
     *
     * @param string|null $city
     * @return void
     */
    public function setCity(string $city = null): void
    {
        $this->city = $city;
    }

    /**
     * Get Street
     *
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Set Street
     *
     * @param string|null $street
     * @return void
     */
    public function setStreet(string $street = null): void
    {
        $this->street = $street;
    }

    /**
     * Get Phone
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set Phone
     *
     * @param string|null $phone
     * @return void
     */
    public function setPhone(string $phone = null): void
    {
        $this->phone = $phone;
    }

    /**
     * Get Email.
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set Email.
     *
     * @param string|null $email
     * @return void
     */
    public function setEmail(string $email = null): void
    {
        $this->email = $email;
    }

    /**
     * Get Gps latitude
     *
     * @return float|null
     */
    public function getGpsLati(): ?float
    {
        return $this->gps_lati;
    }

    /**
     * Set Gps Latitude.
     *
     * @param float|null $gps_lati
     * @return void
     */
    public function setGpsLati(float $gps_lati = null): void
    {
        $this->gps_lati = $gps_lati;
    }

    /**
     * Get gps longitude.
     *
     * @return float|null
     */
    public function getGpsLong(): ?float
    {
        return $this->gps_long;
    }

    /**
     * Set gps Longitude.
     *
     * @param float|null $gps_long
     * @return void
     */
    public function setGpsLong(float $gps_long = null): void
    {
        $this->gps_long = $gps_long;
    }

    /**
     * Get Mon open.
     *
     * @return string|null
     */
    public function getMonOpen(): ?string
    {
        return $this->mon_open;
    }

    /**
     * Set Mon open.
     *
     * @param string|null $mon_open
     * @return void
     */
    public function setMonOpen(string $mon_open = null): void
    {
        $this->mon_open = $mon_open;
    }

    /**
     * Get Mon Close
     *
     * @return string|null
     */
    public function getMonClose(): ?string
    {
        return $this->mon_close;
    }

    /**
     * Set Mon Close.
     *
     * @param string|null $mon_close
     * @return void
     */
    public function setMonClose(string $mon_close = null): void
    {
        $this->mon_close = $mon_close;
    }

    /**
     * Get Tue Open
     *
     * @return string|null
     */
    public function getTueOpen(): ?string
    {
        return $this->tue_open;
    }

    /**
     * Set Tue Open
     *
     * @param string|null $tue_open
     * @return void
     */
    public function setTueOpen(string $tue_open = null): void
    {
        $this->tue_open = $tue_open;
    }

    /**
     * Get Tue Close
     *
     * @return string|null
     */
    public function getTueClose(): ?string
    {
        return $this->tue_close;
    }

    /**
     * Set Tue Close
     *
     * @param string|null $tue_close
     * @return void
     */
    public function setTueClose(string $tue_close = null): void
    {
        $this->tue_close = $tue_close;
    }

    /**
     * Get Wed Open.
     *
     * @return string|null
     */
    public function getWedOpen(): ?string
    {
        return $this->wed_open;
    }

    /**
     * Set Wed Open.
     *
     * @param string|null $wed_open
     * @return void
     */
    public function setWedOpen(string $wed_open = null): void
    {
        $this->wed_open = $wed_open;
    }

    /**
     * Get Wed Close
     *
     * @return string|null
     */
    public function getWedClose(): ?string
    {
        return $this->wed_close;
    }

    /**
     * Set Wed Close
     *
     * @param string|null $wed_close
     * @return void
     */
    public function setWedClose(string $wed_close = null): void
    {
        $this->wed_close = $wed_close;
    }

    /**
     * Get Thu Open
     *
     * @return string|null
     */
    public function getThuOpen(): ?string
    {
        return $this->thu_open;
    }

    /**
     * Set Thu Open
     *
     * @param string|null $thu_open
     * @return void
     */
    public function setThuOpen(string $thu_open = null): void
    {
        $this->thu_open = $thu_open;
    }

    /**
     * Get Thu Close
     *
     * @return string|null
     */
    public function getThuClose(): ?string
    {
        return $this->thu_close;
    }

    /**
     * Set Thu Close
     *
     * @param string|null $thu_close
     * @return void
     */
    public function setThuClose(string $thu_close = null): void
    {
        $this->thu_close = $thu_close;
    }

    /**
     * Get Fri Open
     *
     * @return string|null
     */
    public function getFriOpen(): ?string
    {
        return $this->fri_open;
    }

    /**
     * Set Fri Open
     *
     * @param string|null $fri_open
     * @return void
     */
    public function setFriOpen(string $fri_open = null): void
    {
        $this->fri_open = $fri_open;
    }

    /**
     * Get Fri Close
     *
     * @return string|null
     */
    public function getFriClose(): ?string
    {
        return $this->fri_close;
    }

    /**
     * Set Fri Close
     *
     * @param string|null $fri_close
     */
    public function setFriClose(string $fri_close = null): void
    {
        $this->fri_close = $fri_close;
    }

    /**
     * Get Sat Open
     *
     * @return string|null
     */
    public function getSatOpen(): ?string
    {
        return $this->sat_open;
    }

    /**
     * Set Sat Open
     *
     * @param string|null $sat_open
     * @return void
     */
    public function setSatOpen(string $sat_open = null): void
    {
        $this->sat_open = $sat_open;
    }

    /**
     * Get Sat Close
     *
     * @return string|null
     */
    public function getSatClose(): ?string
    {
        return $this->sat_close;
    }

    /**
     * Set Sat close
     *
     * @param string|null $sat_close
     * @return void
     */
    public function setSatClose(string $sat_close = null): void
    {
        $this->sat_close = $sat_close;
    }

    /**
     * Get Sun Open
     *
     * @return string|null
     */
    public function getSunOpen(): ?string
    {
        return $this->sun_open;
    }

    /**
     * Set Sun open
     *
     * @param string|null $sun_open
     * @return void
     */
    public function setSunOpen(string $sun_open = null): void
    {
        $this->sun_open = $sun_open;
    }

    /**
     * Get Sun close
     *
     * @return string|null
     */
    public function getSunClose(): ?string
    {
        return $this->sun_close;
    }

    /**
     * Set Sun closex
     *
     * @param string|null $sun_close
     * @return void
     */
    public function setSunClose(string $sun_close = null): void
    {
        $this->sun_close = $sun_close;
    }
}

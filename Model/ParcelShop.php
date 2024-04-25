<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Parcel\ParcelShopInterface;

class ParcelShop implements ParcelShopInterface
{
    /** @var string */
    public string $id;

    /** @var string */
    public string $name1;

    /** @var string|null */
    public ?string $name2;

    /** @var string|null */
    public ?string $name3;

    /** @var string */
    public string $country;

    /** @var string */
    public string $zipcode;

    /** @var string */
    public string $city;

    /** @var string */
    public string $street;

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

    /** @var float|null|null */
    public ?float $distance = null;

    /**
     *  Class constructor.
     *
     * @param string $id
     * @param string $name1
     * @param string $country
     * @param string $zipcode
     * @param string $city
     * @param string $street
     * @param string|null $name2
     * @param string|null $name3
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
     * @param float|null $distance
     */
    public function __construct(
        string $id,
        string $name1,
        string $country,
        string $zipcode,
        string $city,
        string $street,
        string $name2 = null,
        string $name3 = null,
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
        string $sun_close = null,
        float $distance = null
    ) {
        $this->setId($id);
        $this->setName1($name1);
        $this->setCountry($country);
        $this->setZipcode($zipcode);
        $this->setCity($city);
        $this->setStreet($street);
        $this->setName2($name2);
        $this->setName3($name3);
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
        $this->setDistance($distance);
    }

    /**
     * Get ID.
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Set ID.
     *
     * @param string $id
     * @return void
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * Get Name1.
     *
     * @return string
     */
    public function getName1(): string
    {
        return $this->name1;
    }

    /**
     * Set Name1.
     *
     * @param string $name1
     * @return void
     */
    public function setName1(string $name1): void
    {
        $this->name1 = $name1;
    }

    /**
     * Get Name2.
     *
     * @return string|null
     */
    public function getName2(): ?string
    {
        return $this->name2;
    }

    /**
     * Set Name2.
     *
     * @param string|null $name2
     * @return void
     */
    public function setName2(string $name2 = null): void
    {
        $this->name2 = $name2;
    }

    /**
     * Get Name3.
     *
     * @return string|null
     */
    public function getName3(): ?string
    {
        return $this->name3;
    }

    /**
     * Set Name3.
     *
     * @param string|null $name3
     * @return void
     */
    public function setName3(string $name3 = null): void
    {
        $this->name3 = $name3;
    }

    /**
     * Get Country.
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
     * Set City.
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
     * Get Phone.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set Phone.
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
     * Get GpsLati.
     *
     * @return float|null
     */
    public function getGpsLati(): ?float
    {
        return $this->gps_lati;
    }

    /**
     * Set GpsLati.
     *
     * @param float|null $gps_lati
     * @return void
     */
    public function setGpsLati(float $gps_lati = null): void
    {
        $this->gps_lati = $gps_lati;
    }

    /**
     * Get GpsLong.
     *
     * @return float|null
     */
    public function getGpsLong(): ?float
    {
        return $this->gps_long;
    }

    /**
     * Set GpsLong.
     *
     * @param float|null $gps_long
     * @return void
     */
    public function setGpsLong(float $gps_long = null): void
    {
        $this->gps_long = $gps_long;
    }

    /**
     * Get MonOpen.
     *
     * @return string|null
     */
    public function getMonOpen(): ?string
    {
        return $this->mon_open;
    }

    /**
     * Set MonOpen.
     *
     * @param string|null $mon_open
     * @return void
     */
    public function setMonOpen(string $mon_open = null): void
    {
        $this->mon_open = $mon_open;
    }

    /**
     * Get MonClose.
     *
     * @return string|null
     */
    public function getMonClose(): ?string
    {
        return $this->mon_close;
    }

    /**
     * Set MonClose.
     *
     * @param string|null $mon_close
     * @return void
     */
    public function setMonClose(string $mon_close = null): void
    {
        $this->mon_close = $mon_close;
    }

    /**
     * Get TueOpen.
     *
     * @return string|null
     */
    public function getTueOpen(): ?string
    {
        return $this->tue_open;
    }

    /**
     * Set TueOpen.
     *
     * @param string|null $tue_open
     * @return void
     */
    public function setTueOpen(string $tue_open = null): void
    {
        $this->tue_open = $tue_open;
    }

    /**
     * Get TueClose.
     *
     * @return string|null
     */
    public function getTueClose(): ?string
    {
        return $this->tue_close;
    }

    /**
     * Set TueClose.
     *
     * @param string|null $tue_close
     * @return void
     */
    public function setTueClose(string $tue_close = null): void
    {
        $this->tue_close = $tue_close;
    }

    /**
     * Get WedOpen.
     *
     * @return string|null
     */
    public function getWedOpen(): ?string
    {
        return $this->wed_open;
    }

    /**
     * Set WedOpen.
     *
     * @param string|null $wed_open
     * @return void
     */
    public function setWedOpen(string $wed_open = null): void
    {
        $this->wed_open = $wed_open;
    }

    /**
     * Get WedClose.
     *
     * @return string|null
     */
    public function getWedClose(): ?string
    {
        return $this->wed_close;
    }

    /**
     * Set WedClose.
     *
     * @param string|null $wed_close
     * @return void
     */
    public function setWedClose(string $wed_close = null): void
    {
        $this->wed_close = $wed_close;
    }

    /**
     * Get ThuOpen.
     *
     * @return string|null
     */
    public function getThuOpen(): ?string
    {
        return $this->thu_open;
    }

    /**
     * Set ThuOpen.
     *
     * @param string|null $thu_open
     * @return void
     */
    public function setThuOpen(string $thu_open = null): void
    {
        $this->thu_open = $thu_open;
    }

    /**
     * Get ThuClose.
     *
     * @return string|null
     */
    public function getThuClose(): ?string
    {
        return $this->thu_close;
    }

    /**
     * Set ThuClose.
     *
     * @param string|null $thu_close
     * @return void
     */
    public function setThuClose(string $thu_close = null): void
    {
        $this->thu_close = $thu_close;
    }

    /**
     * Get FriOpen.
     *
     * @return string|null
     */
    public function getFriOpen(): ?string
    {
        return $this->fri_open;
    }

    /**
     * Set FriOpen.
     *
     * @param string|null $fri_open
     * @return void
     */
    public function setFriOpen(string $fri_open = null): void
    {
        $this->fri_open = $fri_open;
    }

    /**
     * Get FriClose.
     *
     * @return string|null
     */
    public function getFriClose(): ?string
    {
        return $this->fri_close;
    }

    /**
     * Set FriClose.
     *
     * @param string|null $fri_close
     * @return void
     */
    public function setFriClose(string $fri_close = null): void
    {
        $this->fri_close = $fri_close;
    }

    /**
     * Get SatOpen.
     *
     * @return string|null
     */
    public function getSatOpen(): ?string
    {
        return $this->sat_open;
    }

    /**
     * Set SatOpen.
     *
     * @param string|null $sat_open
     * @return void
     */
    public function setSatOpen(string $sat_open = null): void
    {
        $this->sat_open = $sat_open;
    }

    /**
     * Get SatClose.
     *
     * @return string|null
     */
    public function getSatClose(): ?string
    {
        return $this->sat_close;
    }

    /**
     * Set SatClose.
     *
     * @param string|null $sat_close
     * @return void
     */
    public function setSatClose(string $sat_close = null): void
    {
        $this->sat_close = $sat_close;
    }

    /**
     * Get SunOpen.
     *
     * @return string|null
     */
    public function getSunOpen(): ?string
    {
        return $this->sun_open;
    }

    /**
     * Set SunOpen.
     *
     * @param string|null $sun_open
     * @return void
     */
    public function setSunOpen(string $sun_open = null): void
    {
        $this->sun_open = $sun_open;
    }

    /**
     * Get SunClose.
     *
     * @return string|null
     */
    public function getSunClose(): ?string
    {
        return $this->sun_close;
    }

    /**
     * Set SunClose.
     *
     * @param string|null $sun_close
     * @return void
     */
    public function setSunClose(string $sun_close = null): void
    {
        $this->sun_close = $sun_close;
    }

    /**
     * Get Distance.
     *
     * @return float|null
     */
    public function getDistance(): ?float
    {
        return $this->distance;
    }

    /**
     * Set Distance.
     *
     * @param float|null $distance
     * @return void
     */
    public function setDistance(?float $distance = null): void
    {
        $this->distance = $distance;
    }
}

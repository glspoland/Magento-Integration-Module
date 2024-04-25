<?php

namespace GlsPoland\Shipping\Api\Parcel;

interface ParcelShopInterface
{
    /**
     * Get ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Set ID
     *
     * @param string $id
     * @return void
     */
    public function setId(string $id): void;

    /**
     * Get name1
     *
     * @return string
     */
    public function getName1(): string;

    /**
     * Set name1
     *
     * @param string $name1
     * @return void
     */
    public function setName1(string $name1): void;

    /**
     * Get name2
     *
     * @return string|null
     */
    public function getName2(): ?string;

    /**
     * Set name2
     *
     * @param string|null $name2
     * @return void
     */
    public function setName2(string $name2 = null): void;

    /**
     * Get name3
     *
     * @return string|null
     */
    public function getName3(): ?string;

    /**
     * Set name3
     *
     * @param string|null $name3
     * @return void
     */
    public function setName3(string $name3 = null): void;

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry(): string;

    /**
     * Set country
     *
     * @param string $country
     * @return void
     */
    public function setCountry(string $country): void;

    /**
     * Get zipcode
     *
     * @return string
     */
    public function getZipcode(): string;

    /**
     * Set zipcode
     *
     * @param string $zipcode
     * @return void
     */
    public function setZipcode(string $zipcode): void;

    /**
     * Get city
     *
     * @return string
     */
    public function getCity(): string;

    /**
     * Set city
     *
     * @param string $city
     * @return void
     */
    public function setCity(string $city): void;

    /**
     * Get street
     *
     * @return string
     */
    public function getStreet(): string;

    /**
     * Set street
     *
     * @param string $street
     * @return void
     */
    public function setStreet(string $street): void;

    /**
     * Get phone
     *
     * @return string|null
     */
    public function getPhone(): ?string;

    /**
     * Set phone
     *
     * @param string|null $phone
     * @return void
     */
    public function setPhone(string $phone = null): void;

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail(): ?string;

    /**
     * Set email
     *
     * @param string|null $email
     * @return void
     */
    public function setEmail(string $email = null): void;

    /**
     * Get gps_lati
     *
     * @return float|null
     */
    public function getGpsLati(): ?float;

    /**
     * Set gps_lati
     *
     * @param float|null $gps_lati
     * @return void
     */
    public function setGpsLati(float $gps_lati = null): void;

    /**
     * Get gps_long
     *
     * @return float|null
     */
    public function getGpsLong(): ?float;

    /**
     * Set gps_long
     *
     * @param float|null $gps_long
     * @return void
     */
    public function setGpsLong(float $gps_long = null): void;

    /**
     * Get MonOpen.
     *
     * @return string|null
     */
    public function getMonOpen(): ?string;

    /**
     * Set MonOpen.
     *
     * @param string|null $mon_open
     * @return void
     */
    public function setMonOpen(string $mon_open = null): void;

    /**
     * Get MonClose.
     *
     * @return string|null
     */
    public function getMonClose(): ?string;

    /**
     * Set MonClose.
     *
     * @param string|null $mon_close
     * @return void
     */
    public function setMonClose(string $mon_close = null): void;

    /**
     * Get TueOpen.
     *
     * @return string|null
     */
    public function getTueOpen(): ?string;

    /**
     * Set TueOpen.
     *
     * @param string|null $tue_open
     * @return void
     */
    public function setTueOpen(string $tue_open = null): void;

    /**
     * Get TueClose.
     *
     * @return string|null
     */
    public function getTueClose(): ?string;

    /**
     * Set TueClose.
     *
     * @param string|null $tue_close
     * @return void
     */
    public function setTueClose(string $tue_close = null): void;

    /**
     * Get WedOpen.
     *
     * @return string|null
     */
    public function getWedOpen(): ?string;

    /**
     * Set WedOpen.
     *
     * @param string|null $wed_open
     * @return void
     */
    public function setWedOpen(string $wed_open = null): void;

    /**
     * Get WedClose.
     *
     * @return string|null
     */
    public function getWedClose(): ?string;

    /**
     * Set WedClose.
     *
     * @param string|null $wed_close
     * @return void
     */
    public function setWedClose(string $wed_close = null): void;

    /**
     * Get ThuOpen.
     *
     * @return string|null
     */
    public function getThuOpen(): ?string;

    /**
     * Set ThuOpen.
     *
     * @param string|null $thu_open
     * @return void
     */
    public function setThuOpen(string $thu_open = null): void;

    /**
     * Get ThuClose.
     *
     * @return string|null
     */
    public function getThuClose(): ?string;

    /**
     * Set ThuClose.
     *
     * @param string|null $thu_close
     * @return void
     */
    public function setThuClose(string $thu_close = null): void;

    /**
     * Get FriOpen.
     *
     * @return string|null
     */
    public function getFriOpen(): ?string;

    /**
     * Set FriOpen.
     *
     * @param string|null $fri_open
     * @return void
     */
    public function setFriOpen(string $fri_open = null): void;

    /**
     * Get FriClose.
     *
     * @return string|null
     */
    public function getFriClose(): ?string;

    /**
     * Set FriClose.
     *
     * @param string|null $fri_close
     * @return void
     */
    public function setFriClose(string $fri_close = null): void;

    /**
     * Get SatOpen.
     *
     * @return string|null
     */
    public function getSatOpen(): ?string;

    /**
     * Set SatOpen.
     *
     * @param string|null $sat_open
     * @return void
     */
    public function setSatOpen(string $sat_open = null): void;

    /**
     * Get SatClose.
     *
     * @return string|null
     */
    public function getSatClose(): ?string;

    /**
     * Set SatClose.
     *
     * @param string|null $sat_close
     * @return void
     */
    public function setSatClose(string $sat_close = null): void;

    /**
     * Get SunOpen.
     *
     * @return string|null
     */
    public function getSunOpen(): ?string;

    /**
     * Set SunOpen.
     *
     * @param string|null $sun_open
     * @return void
     */
    public function setSunOpen(string $sun_open = null): void;

    /**
     * Get SunClose.
     *
     * @return string|null
     */
    public function getSunClose(): ?string;

    /**
     * Set SunClose.
     *
     * @param string|null $sun_close
     * @return void
     */
    public function setSunClose(string $sun_close = null): void;

    /**
     * Get Distance.
     *
     * @return float|null
     */
    public function getDistance(): ?float;

    /**
     * Set Distance.
     *
     * @param float|null $distance
     * @return void
     */
    public function setDistance(?float $distance = null): void;
}

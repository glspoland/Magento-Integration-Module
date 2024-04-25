<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use InvalidArgumentException;

class ServiceDAW
{
    /** @var string */
    public string $name;

    /** @var string|null */
    public ?string $building;

    /** @var string|null */
    public ?string $floor;

    /** @var string|null */
    public ?string $room;

    /** @var string|null */
    public ?string $phone;

    /** @var string|null */
    public ?string $altrec;

    /**
     * @param string $name
     * @param string|null $building
     * @param string|null $floor
     * @param string|null $room
     * @param string|null $phone
     * @param string|null $altrec
     */
    public function __construct(
        string $name,
        string $building = null,
        string $floor = null,
        string $room = null,
        string $phone = null,
        string $altrec = null
    ) {
        $this->setName($name);
        $this->setBuilding($building);
        $this->setFloor($floor);
        $this->setRoom($room);
        $this->setPhone($phone);
        $this->setAltrec($altrec);
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
     * @param string|null $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get Building
     *
     * @return string|null
     */
    public function getBuilding(): ?string
    {
        return $this->building;
    }

    /**
     * Set Building
     *
     * @param string|null $building
     * @return void
     */
    public function setBuilding(string $building = null): void
    {
        $this->building = $building;
    }

    /**
     * Get Floor
     *
     * @return string|null
     */
    public function getFloor(): ?string
    {
        return $this->floor;
    }

    /**
     * Set Floor
     *
     * @param string|null $floor
     * @return void
     */
    public function setFloor(string $floor = null): void
    {
        $this->floor = $floor;
    }

    /**
     * Get Room
     *
     * @return string|null
     */
    public function getRoom(): ?string
    {
        return $this->room;
    }

    /**
     * Set Room
     *
     * @param string|null $room
     * @return void
     */
    public function setRoom(string $room = null): void
    {
        $this->room = $room;
    }

    /**
     * Get Phone number.
     *
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set Phone number.
     *
     * @param string|null $phone
     * @return void
     */
    public function setPhone(string $phone = null): void
    {
        $this->phone = $phone;
    }

    /**
     * Get Altrec
     *
     * @return string|null
     */
    public function getAltrec(): ?string
    {
        return $this->altrec;
    }

    /**
     * Set Altrec
     *
     * @param string|null $altrec
     * @return void
     */
    public function setAltrec(string $altrec = null): void
    {
        $this->altrec = $altrec;
    }
}

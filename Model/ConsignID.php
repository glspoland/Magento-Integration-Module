<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Consign\ConsignIDInterface;

class ConsignID implements ConsignIDInterface
{
    /**  @var int */
    public int $id;

    /**
     * Class constructor.
     *
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->setId($id);
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
}

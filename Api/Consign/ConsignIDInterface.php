<?php

namespace GlsPoland\Shipping\Api\Consign;

interface ConsignIDInterface
{
    /**
     * Get id.
     *
     * @return int
     */
    public function getId(): int;

    /**
     * Set id.
     *
     * @param int $id
     * @return void
     */
    public function setId(int $id): void;
}

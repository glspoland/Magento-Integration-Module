<?php

namespace GlsPoland\Shipping\Api\Pod;

interface PodInterface
{
    /**
     * Get number
     *
     * @return string
     */
    public function getNumber(): string;

    /**
     * Set number
     *
     * @param string $number
     * @return void
     */
    public function setNumber(string $number): void;

    /**
     * Get file
     *
     * @return string
     */
    public function getFilepdf(): string;

    /**
     * Set file
     *
     * @param string $file_pdf
     * @return void
     */
    public function setFilepdf(string $file_pdf): void;
}

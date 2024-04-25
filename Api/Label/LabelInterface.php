<?php

namespace GlsPoland\Shipping\Api\Label;

interface LabelInterface
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
    public function getFile(): string;

    /**
     * Set file
     *
     * @param string $file
     * @return void
     */
    public function setFile(string $file): void;
}

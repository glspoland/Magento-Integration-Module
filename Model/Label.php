<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Label\LabelInterface;

class Label implements LabelInterface
{
    /** @var string */
    public string $number;

    /** @var string */
    public string $file;

    /**
     * Constructor method.
     *
     * @param string $number
     * @param string $file
     */
    public function __construct(string $number, string $file)
    {
        $this->setNumber($number);
        $this->setFile($file);
    }

    /**
     * Get number.
     *
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * Set number.
     *
     * @param string $number
     * @return void
     */
    public function setNumber(string $number): void
    {
        $this->number = $number;
    }

    /**
     * Get file.
     *
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * Set file.
     *
     * @param string $file
     * @return void
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }
}

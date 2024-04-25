<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use GlsPoland\Shipping\Api\Pod\PodInterface;

class Pod implements PodInterface
{
    /** @var string */
    public string $number;

    /** @var string */
    public string $file_pdf;

    /**
     * Constructor method.
     *
     * @param string $number
     * @param string $file_pdf
     */
    public function __construct(string $number, string $file_pdf)
    {
        $this->setNumber($number);
        $this->setFilepdf($file_pdf);
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
    public function getFilepdf(): string
    {
        return $this->file_pdf;
    }

    /**
     * Set file.
     *
     * @param string $file_pdf
     * @return void
     */
    public function setFilepdf(string $file_pdf): void
    {
        $this->file_pdf = $file_pdf;
    }
}

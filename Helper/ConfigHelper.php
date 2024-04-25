<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Helper;

use Magento\Framework\Serialize\SerializerInterface;

class ConfigHelper
{
    /** @var SerializerInterface */
    protected SerializerInterface $serializer;

    /**
     * Class constructor
     *
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Convert mixed value to float
     *
     * @param mixed $value
     * @return float
     */
    public function toFloat(mixed $value): float
    {
        if (is_string($value)) {
            $value = trim($value);
            $value = str_replace(',', '.', $value);
        }

        if (empty($value) || $value === '0.0') {
            return 0.0;
        }

        return (float)$value;
    }
}

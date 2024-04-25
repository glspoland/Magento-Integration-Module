<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use ReflectionFunction;

class Base64Helper extends AbstractHelper
{
    /**
     * Encode data to base64 format
     *
     * @param string $data
     * @return string
     */
    public function encode(string $data): string
    {
        return base64_encode($data);
    }

    /**
     * Decode data from base64 format
     *
     * @param string $data
     * @return false|string
     */
    public function decode(string $data): bool|string
    {
        if ($this->isValid($data)) {
            return (new ReflectionFunction('base64_decode'))->invoke($data, true);
        }

        return false;
    }

    /**
     * Check if data is valid base64 encoded string
     *
     * @param string $data
     * @return bool
     */
    private function isValid(string $data): bool
    {
        if (strlen($data) % 4 !== 0) {
            return false;
        }

        if (!preg_match('/^[a-zA-Z0-9\/\r\n+]*={0,2}$/', $data)) {
            return false;
        }

        return (base64_encode((new ReflectionFunction('base64_decode'))->invoke($data, true)) === $data);
    }
}

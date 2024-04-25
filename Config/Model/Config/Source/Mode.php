<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Config\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Mode implements OptionSourceInterface
{
    /**
     * Module run mode options.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            ['value' => 'production', 'label' => __('Production mode')],
            ['value' => 'sandbox', 'label' => __('Sandbox mode')]
        ];
    }
}

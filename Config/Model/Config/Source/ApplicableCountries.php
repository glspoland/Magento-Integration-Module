<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Config\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ApplicableCountries implements OptionSourceInterface
{
    /**
     * Get Applicable countries options.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => '0',
                'label' => __('All Allowed Countries')
            ],
            [
                'value' => '1',
                'label' => __('Specific Countries')
            ]
        ];
    }
}

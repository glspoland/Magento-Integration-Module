<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Config\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class LabelPrint implements OptionSourceInterface
{
    /**
     * Get Label print options.
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => 'one_label_on_a4_lt_pdf',
                'label' => __('one label per A4, top left corner')
            ],
            [
                'value' => 'four_labels_on_a4_pdf',
                'label' => __('four labels on A4, first label printed from the left')
            ],
            [
                'value' => 'roll_160x100_pdf',
                'label' => __('roll, PDF file (horizontal)')
            ],
            [
                'value' => 'roll_160x100_vertical_pdf',
                'label' => __('roll, PDF file (vertical)')
            ],
            [
                'value' => 'roll_160x100_datamax',
                'label' => __('roll, DPL language file')
            ],
            [
                'value' => 'roll_160x100_zebra',
                'label' => __('roll, ZPL language file')
            ],
            [
                'value' => 'roll_160x100_zebra_300',
                'label' => __('roll, ZPL language file, 300dpi resolution')
            ],
            [
                'value' => 'roll_160x100_zebra_epl',
                'label' => __('roll, EPL language file')
            ],
        ];
    }
}

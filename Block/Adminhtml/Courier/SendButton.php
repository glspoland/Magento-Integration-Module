<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Adminhtml\Courier;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;

class SendButton extends Generic
{
    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Send Courier Order'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 10,
        ];
    }
}

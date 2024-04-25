<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Config\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Sales\Model\Config\Source\Order\Status;

class OrderStatus implements OptionSourceInterface
{
    /**
     * @var Status
     */
    protected Status $statusSource;

    /**
     * @param Status $statusSource
     */
    public function __construct(Status $statusSource)
    {
        $this->statusSource = $statusSource;
    }

    /**
     * Get Order statuses
     *
     * @return array
     */
    public function toOptionArray(): array
    {
        $options = [];
        $orderStatuses = $this->statusSource->toOptionArray();

        foreach ($orderStatuses as $status) {
            $options[] = [
                'value' => 'status_' . $status['value'],
                'label' => $status['label'],
            ];
        }

        return $options;
    }
}

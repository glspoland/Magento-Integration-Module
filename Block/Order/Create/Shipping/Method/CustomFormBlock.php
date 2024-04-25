<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Order\Create\Shipping\Method;

use Magento\Quote\Model\Quote\Item;
use Magento\Sales\Block\Adminhtml\Order\Create\Shipping\Method\Form;

class CustomFormBlock extends Form
{
    /**
     * Get quote weight
     *
     * @return ?float
     */
    public function getQuoteWeight(): ?float
    {
        $quote = $this->getQuote();

        if ($quote === null) {
            return null;
        }

        $items = $this->getQuote()->getAllItems();

        if (empty($items)) {
            return null;
        }

        $weight = 0.0;

        /** @var Item $item */
        foreach ($items as $item) {
            if ($item !== null) {
                $qty = $item->getQty();
                $weight += (float)$item->getWeight() * $qty;
            }
        }

        if ($weight === 0.0) {
            return null;
        }

        return $weight;
    }
}

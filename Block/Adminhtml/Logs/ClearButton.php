<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Block\Adminhtml\Logs;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ClearButton implements ButtonProviderInterface
{
    /** @var UrlInterface */
    protected UrlInterface $urlBuilder;

    /**
     * ClearButton constructor.
     *
     * @param UrlInterface $urlBuilder
     */
    public function __construct(UrlInterface $urlBuilder)
    {
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * Retrieve button-specified settings
     *
     * @return array
     */
    public function getButtonData(): array
    {
        $url = $this->urlBuilder->getUrl('gls_poland/logs/clear');
        $msg = __('Are you sure you want to remove all logs?');

        return [
            'label' => __('Remove all logs'),
            'class' => 'primary',
            'on_click' => sprintf("deleteConfirm('%s', '%s')", $msg, $url),
            'sort_order' => 10,
        ];
    }
}

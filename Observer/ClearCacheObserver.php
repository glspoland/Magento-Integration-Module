<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Observer;

use GlsPoland\Shipping\Model\Cache;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class ClearCacheObserver implements ObserverInterface
{
    /** @var Cache */
    private Cache $cache;

    /**
     * Constructor class
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Execute observer
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $this->cache->clearCache();
    }
}

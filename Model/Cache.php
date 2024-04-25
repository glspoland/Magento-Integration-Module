<?php

declare(strict_types=1);

namespace GlsPoland\Shipping\Model;

use Magento\Framework\App\CacheInterface;
use Magento\Framework\Serialize\SerializerInterface;

class Cache
{
    private const CACHE_TAG = ['gls_poland'];

    /** @var CacheInterface */
    private CacheInterface $cache;

    /** @var SerializerInterface */
    private SerializerInterface $serializer;

    /**
     * Class constructor.
     *
     * @param CacheInterface $cache
     * @param SerializerInterface $serializer
     */
    public function __construct(CacheInterface $cache, SerializerInterface $serializer)
    {
        $this->cache = $cache;
        $this->serializer = $serializer;
    }

    /**
     * Load Cache
     *
     * @param string $identifier
     * @param mixed $allowedClasses
     * @return array|null
     */
    public function loadCache(string $identifier, mixed $allowedClasses): ?array
    {
        $cachedData = $this->cache->load($identifier);

        if (is_string($cachedData)) {
            return $this->serializer->unserialize($cachedData, ['allowed_classes' => $allowedClasses]);
        }

        return null;
    }

    /**
     * Update cache with current items.
     *
     * @param mixed $data
     * @param string $identifier
     * @return void
     */
    public function updateCache(mixed $data, string $identifier): void
    {
        $this->cache->save($this->serializer->serialize($data), $identifier, self::CACHE_TAG);
    }

    /**
     * Clear cache.
     *
     * @return void
     */
    public function clearCache(): void
    {
        $this->cache->clean(self::CACHE_TAG);
    }
}

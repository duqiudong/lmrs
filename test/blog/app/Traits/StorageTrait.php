<?php

namespace App\Traits;

use Cache;

/**
 * 存储
 * Trait StorageTrait
 * @package App\Traits
 */
trait StorageTrait {
    /**
     * 缓存
     * @var object cache
     */
    protected object $cache;

    /**
     * redis cache
     * @return \Illuminate\Contracts\Cache\Repository
     */
    public function redisCache() {
        return Cache::store('redis');
    }
}
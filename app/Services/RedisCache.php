<?php

namespace App\Services;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class RedisCache extends Cache
{
    private static $foreverTtl = 999999999 * 60 * 24;

    public static function remember($key, $ttl, $data)
    {
        if (Redis::exists($key)) {
            return unserialize(Redis::get($key));
        }
        Redis::set($key, serialize($data()));
        Redis::expire($key, $ttl);
        return $data();
    }

    public static function rememberForever($key, $data)
    {
        return static::remember($key, static::$foreverTtl, $data);
    }

    public static function delete($key)
    {
        return Redis::del($key);
    }

    public static function flushAll()
    {
        return Redis::flushAll();
    }

}
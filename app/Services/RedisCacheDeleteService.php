<?php
namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisCacheDeleteService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function wildcardDelete($wildCardKey, $switch = 1)
    {
        Redis::select($switch);
        $keys          = Redis::keys($wildCardKey);
        $redisDBPrefix = config('database.redis.options.prefix');
        $cachePrefix   = config('cache.prefix');

        foreach ($keys as $key) {
            Redis::del(substr($key, strlen($redisDBPrefix . $cachePrefix)));
        }
    }
}

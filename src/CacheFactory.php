<?php

declare(strict_types=1);

namespace Inspire\Cache;

use Cache\Adapter\Common\AbstractCachePool;

/**
 * Description of CacheFactory
 *
 * @author aalves
 */
abstract class CacheFactory
{

    /**
     * Get logger instance
     *
     * @param string $level
     * @return AbstractCachePool|null
     */
    public static function create(?string $channel = null): ?AbstractCachePool
    {
        if (($cache = \Inspire\Config\Config::get("cache")) !== null) {
            $channel = $channel === 'default' ? null : $channel;
            if (isset($cache[$channel]) && isset($cache[$channel]['driver'])) {
                $config = $cache[$channel];
                switch ($cache[$channel]['driver']) {
                    case 'redis':
                        try {
                            if (!class_exists('\\Redis')) {
                                throw new \Exception("Redis extension is not installed or not enabled.");
                            }
                            $redis = new \Redis();
                            $redis->connect($config['host'], $config['port']);
                            if (isset($config['pass']) && !empty($config['pass'])) {
                                $redis->auth($config['pass']);
                            }
                            if (!$redis->isConnected()) {
                                throw new \Exception("Could not connect to Redis server in {$config['host']}");
                            }
                            if (isset($config['database']) && $config['database'] !== null && is_int($config['database'])) {
                                $redis->select($config['database']);
                            }
                            $pool = new RedisCache($redis);
                            return $pool;
                        } catch (\RedisException $e) {
                            echo $e->getTraceAsString();
                            return null;
                        }
                    case 'array':
                        return new ArrayCache();
                    case 'memcached':
                        if (!class_exists('\\Memcached')) {
                            throw new \Exception("Memcached extension is not installed or not enabled.");
                        }
                        $memcached = new \Memcached();
                        $memcached->addServer($config['host'], $config['port']);
                        $statuses = $memcached->getStats();
                        if (!isset($statuses["{$config['host']}:{$config['port']}"]) || intval($statuses["{$config['host']}:{$config['port']}"]['pid']) < 0) {
                            throw new \Exception("Could not connect to Memcached server in {$config['host']}");
                        }
                        $pool = new MemcachedCache($memcached);
                        return $pool;
                    default:
                        return null;
                }
            }
        }
        return null;
    }
}

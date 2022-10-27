<?php

declare(strict_types=1);

namespace Inspire\Cache;

use Cache\Adapter\PHPArray\ArrayCachePool;

/**
 * Description of ArrayCache
 *
 * @author aalves
 */
final class ArrayCache extends ArrayCachePool
{

    /**
     * @param string $item
     * 
     * @return [type]
     */
    public function lLen(string $item)
    {
        return count($this->cache);
    }
}

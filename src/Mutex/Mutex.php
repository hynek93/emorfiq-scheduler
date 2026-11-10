<?php

declare(strict_types=1);

namespace App\Mutex;

interface Mutex
{
    /**
     * @param non-empty-string $key
     * @param positive-int $ttlSeconds
     */
    public function tryAcquire(string $key, int $ttlSeconds): ?Lock;
}

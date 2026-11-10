<?php

declare(strict_types=1);

namespace App\Mutex;

interface Lock
{
    public function key(): string;

    /**
     * @param positive-int $ttlSeconds
     * @throws LockLostException
     */
    public function refresh(int $ttlSeconds): void;

    public function release(): void;
}

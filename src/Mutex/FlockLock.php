<?php

declare(strict_types=1);

namespace App\Mutex;

final class FlockLock implements Lock
{
    /**
     * @param resource|null $handle
     */
    public function __construct(
        private readonly string $key,
        private mixed $handle,
    ) {
    }

    public function key(): string
    {
        return $this->key;
    }

    public function refresh(int $ttlSeconds): void
    {
    }

    public function release(): void
    {
        if ($this->handle === null) {
            return;
        }

        flock($this->handle, LOCK_UN);
        fclose($this->handle);
        $this->handle = null;
    }
}

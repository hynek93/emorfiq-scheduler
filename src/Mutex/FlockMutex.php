<?php

declare(strict_types=1);

namespace App\Mutex;

final class FlockMutex implements Mutex
{
    public function __construct(private readonly string $directory)
    {
    }

    public function tryAcquire(string $key, int $ttlSeconds): ?Lock
    {
        $path = $this->directory . '/' . sha1($key) . '.lock';

        $handle = fopen($path, 'c');
        if ($handle === false) {
            throw new MutexException("Cannot open lock file $path");
        }

        if (!flock($handle, LOCK_EX | LOCK_NB)) {
            fclose($handle);

            return null;
        }

        return new FlockLock($key, $handle);
    }
}

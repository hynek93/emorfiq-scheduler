<?php

declare(strict_types=1);

namespace App\Scheduling;

use App\Mutex\Lock;

final readonly class TaskContext
{
    /**
     * @param array<string, scalar|null> $parameters
     */
    public function __construct(
        public string $taskId,
        public array $parameters,
        public \DateTimeImmutable $startedAt,
        public ?Lock $lock,
    ) {
    }
}

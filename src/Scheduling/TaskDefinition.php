<?php

declare(strict_types=1);

namespace App\Scheduling;

final readonly class TaskDefinition
{
    /**
     * @param non-empty-string $id
     * @param class-string<TaskHandler> $handler
     * @param array<string, scalar|null> $parameters
     * @param positive-int $lockTtlSeconds
     */
    public function __construct(
        public string $id,
        public CronExpression $cron,
        public string $handler,
        public array $parameters = [],
        public OverlapPolicy $overlap = OverlapPolicy::Skip,
        public int $lockTtlSeconds = 3600,
        public ?\DateTimeZone $timezone = null,
        public ?string $description = null,
    ) {
        if (!preg_match('/^[a-z0-9][a-z0-9._-]*$/', $id)) {
            throw new \InvalidArgumentException("Invalid task id: $id");
        }
        if (!is_subclass_of($handler, TaskHandler::class)) {
            throw new \InvalidArgumentException("$handler must implement " . TaskHandler::class);
        }
        if ($lockTtlSeconds < 1) {
            throw new \InvalidArgumentException('Lock TTL must be positive');
        }
    }
}

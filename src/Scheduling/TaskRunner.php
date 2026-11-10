<?php

declare(strict_types=1);

namespace App\Scheduling;

use App\Mutex\Mutex;
use Psr\Clock\ClockInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

final class TaskRunner
{
    public function __construct(
        private readonly TaskRegistry $registry,
        private readonly Mutex $mutex,
        private readonly ContainerInterface $container,
        private readonly ClockInterface $clock,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function run(string $taskId): TaskResult
    {
        $task = $this->registry->get($taskId);

        $lock = null;
        if ($task->overlap === OverlapPolicy::Skip) {
            $lock = $this->mutex->tryAcquire("task:{$task->id}", $task->lockTtlSeconds);
            if ($lock === null) {
                $this->logger->info('Task skipped, previous run still in progress', ['task' => $task->id]);

                return TaskResult::Skipped;
            }
        }

        try {
            /** @var TaskHandler $handler */
            $handler = $this->container->get($task->handler);
            $context = new TaskContext($task->id, $task->parameters, $this->clock->now(), $lock);

            $this->logger->info('Task started', ['task' => $task->id]);
            $handler->handle($context);
            $this->logger->info('Task finished', ['task' => $task->id]);

            return TaskResult::Succeeded;
        } catch (\Throwable $e) {
            $this->logger->error('Task failed', ['task' => $task->id, 'exception' => $e]);

            return TaskResult::Failed;
        } finally {
            $lock?->release();
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Scheduling;

final class TaskRegistry
{
    /** @var array<string, TaskDefinition> */
    private array $tasks = [];

    /**
     * @param iterable<TaskDefinition> $tasks
     */
    public function __construct(iterable $tasks)
    {
        foreach ($tasks as $task) {
            if (isset($this->tasks[$task->id])) {
                throw new \LogicException("Duplicate task id: {$task->id}");
            }
            $this->tasks[$task->id] = $task;
        }
    }

    public function get(string $id): TaskDefinition
    {
        return $this->tasks[$id] ?? throw new UnknownTaskException($id);
    }

    /**
     * @return list<TaskDefinition>
     */
    public function all(): array
    {
        return array_values($this->tasks);
    }
}

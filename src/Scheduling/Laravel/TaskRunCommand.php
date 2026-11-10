<?php

declare(strict_types=1);

namespace App\Scheduling\Laravel;

use App\Scheduling\TaskResult;
use App\Scheduling\TaskRunner;
use Illuminate\Console\Command;

final class TaskRunCommand extends Command
{
    protected $signature = 'task:run {id : Task ID from the registry}';

    protected $description = 'Run a single task by its ID';

    public function handle(TaskRunner $runner): int
    {
        return match ($runner->run((string) $this->argument('id'))) {
            TaskResult::Succeeded, TaskResult::Skipped => self::SUCCESS,
            TaskResult::Failed => self::FAILURE,
        };
    }
}

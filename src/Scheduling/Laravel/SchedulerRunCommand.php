<?php

declare(strict_types=1);

namespace App\Scheduling\Laravel;

use App\Scheduling\Scheduler;
use App\Scheduling\TaskRegistry;
use Illuminate\Console\Command;

final class SchedulerRunCommand extends Command
{
    protected $signature = 'scheduler:run';

    protected $description = 'Schedule all registered tasks and run the due ones';

    public function handle(Scheduler $scheduler, TaskRegistry $registry): int
    {
        foreach ($registry->all() as $task) {
            $scheduler->schedule($task);
        }

        $scheduler->runDue();

        return self::SUCCESS;
    }
}

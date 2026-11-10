<?php

declare(strict_types=1);

namespace App\Scheduling\Laravel;

use App\Scheduling\Scheduler;
use App\Scheduling\TaskDefinition;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Console\Kernel;

final class LaravelScheduler implements Scheduler
{
    public function __construct(
        private readonly Schedule $schedule,
        private readonly Kernel $artisan,
    ) {
    }

    public function schedule(TaskDefinition $task): void
    {
        $event = $this->schedule
            ->command('task:run', [$task->id])
            ->cron($task->cron->value)
            ->runInBackground()
            ->name($task->id);

        if ($task->timezone !== null) {
            $event->timezone($task->timezone);
        }
    }

    public function runDue(): void
    {
        $this->artisan->call('schedule:run');
    }
}

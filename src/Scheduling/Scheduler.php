<?php

declare(strict_types=1);

namespace App\Scheduling;

interface Scheduler
{
    public function schedule(TaskDefinition $task): void;

    public function runDue(): void;
}

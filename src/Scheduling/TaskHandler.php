<?php

declare(strict_types=1);

namespace App\Scheduling;

interface TaskHandler
{
    public function handle(TaskContext $context): void;
}

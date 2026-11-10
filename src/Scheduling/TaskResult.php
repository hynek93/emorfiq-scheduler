<?php

declare(strict_types=1);

namespace App\Scheduling;

enum TaskResult
{
    case Succeeded;

    case Skipped;

    case Failed;
}

<?php

declare(strict_types=1);

namespace App\Scheduling;

enum OverlapPolicy: string
{
    case Skip = 'skip';

    case Allow = 'allow';
}

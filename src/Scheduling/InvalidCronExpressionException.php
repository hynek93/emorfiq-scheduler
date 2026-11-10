<?php

declare(strict_types=1);

namespace App\Scheduling;

final class InvalidCronExpressionException extends \InvalidArgumentException
{
    public function __construct(string $expression)
    {
        parent::__construct("Invalid cron expression: $expression");
    }
}

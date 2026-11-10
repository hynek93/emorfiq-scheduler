<?php

declare(strict_types=1);

namespace App\Scheduling;

final readonly class CronExpression
{
    private function __construct(public string $value)
    {
    }

    public static function fromString(string $expression): self
    {
        $expression = trim((string) preg_replace('/\s+/', ' ', $expression));

        if (count(explode(' ', $expression)) !== 5
            || !\Cron\CronExpression::isValidExpression($expression)) {
            throw new InvalidCronExpressionException($expression);
        }

        return new self($expression);
    }
}

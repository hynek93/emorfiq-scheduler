<?php

declare(strict_types=1);

namespace App\Scheduling;

final class UnknownTaskException extends \RuntimeException
{
    public function __construct(string $id)
    {
        parent::__construct("Unknown task: $id");
    }
}

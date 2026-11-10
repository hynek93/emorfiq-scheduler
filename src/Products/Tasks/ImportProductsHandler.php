<?php

declare(strict_types=1);

namespace App\Products\Tasks;

use App\Scheduling\TaskContext;
use App\Scheduling\TaskHandler;
use Psr\Log\LoggerInterface;

final class ImportProductsHandler implements TaskHandler
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(TaskContext $context): void
    {
        $supplier = (string) $context->parameters['supplier'];

        $this->logger->info('Products imported', ['supplier' => $supplier]);
    }
}

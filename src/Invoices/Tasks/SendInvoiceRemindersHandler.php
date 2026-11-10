<?php

declare(strict_types=1);

namespace App\Invoices\Tasks;

use App\Scheduling\TaskContext;
use App\Scheduling\TaskHandler;
use Psr\Log\LoggerInterface;

final class SendInvoiceRemindersHandler implements TaskHandler
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }

    public function handle(TaskContext $context): void
    {
        $daysOverdue = (int) $context->parameters['daysOverdue'];

        $this->logger->info('Invoice reminders sent', ['daysOverdue' => $daysOverdue]);
    }
}

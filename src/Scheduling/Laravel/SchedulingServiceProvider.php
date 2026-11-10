<?php

declare(strict_types=1);

namespace App\Scheduling\Laravel;

use App\Invoices\Tasks\SendInvoiceRemindersHandler;
use App\Mutex\FlockMutex;
use App\Mutex\Mutex;
use App\Products\Tasks\ImportProductsHandler;
use App\Scheduling\CronExpression;
use App\Scheduling\Scheduler;
use App\Scheduling\SystemClock;
use App\Scheduling\TaskDefinition;
use App\Scheduling\TaskRegistry;
use Illuminate\Support\ServiceProvider;
use Psr\Clock\ClockInterface;

final class SchedulingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Scheduler::class, LaravelScheduler::class);

        $this->app->singleton(Mutex::class, fn () => new FlockMutex(storage_path('locks')));

        $this->app->singleton(ClockInterface::class, SystemClock::class);

        $this->app->singleton(TaskRegistry::class, fn () => new TaskRegistry([
            new TaskDefinition(
                id: 'products.import.acme',
                cron: CronExpression::fromString('*/15 * * * *'),
                handler: ImportProductsHandler::class,
                parameters: ['supplier' => 'acme'],
                description: 'Import products from supplier ACME',
            ),
            new TaskDefinition(
                id: 'products.import.globex',
                cron: CronExpression::fromString('0 3 * * *'),
                handler: ImportProductsHandler::class,
                parameters: ['supplier' => 'globex'],
                timezone: new \DateTimeZone('Europe/Prague'),
                description: 'Nightly product import from supplier Globex',
            ),
            new TaskDefinition(
                id: 'invoices.send-reminders',
                cron: CronExpression::fromString('0 8 * * 1-5'),
                handler: SendInvoiceRemindersHandler::class,
                parameters: ['daysOverdue' => 14],
                timezone: new \DateTimeZone('Europe/Prague'),
            ),
        ]));
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                SchedulerRunCommand::class,
                TaskRunCommand::class,
            ]);
        }
    }
}

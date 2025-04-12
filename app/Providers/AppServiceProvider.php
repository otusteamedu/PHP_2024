<?php

namespace App\Providers;

use App\Application\AsyncHandler\AsyncHandlerInterface;
use App\Application\Consumer\ConsumerInterface;
use App\Application\LeadHandler\LeadHandlerInterface;
use App\Domain\Factory\LeadFactoryInterface;
use App\Domain\Repository\LeadRepositoryInterface;
use App\Infrastructure\AsyncHandler\RabbitHandler;
use App\Infrastructure\Consumer\Consumer;
use App\Infrastructure\Factory\LeadFactory;
use App\Infrastructure\LeadHandler\DummyLeadHandler;
use App\Infrastructure\Repository\DbLeadRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(LeadRepositoryInterface::class, DbLeadRepository::class);
        $this->app->bind(AsyncHandlerInterface::class, RabbitHandler::class);
        $this->app->bind(ConsumerInterface::class, Consumer::class);
        $this->app->bind(LeadHandlerInterface::class, DummyLeadHandler::class);
        $this->app->bind(LeadFactoryInterface::class, LeadFactory::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

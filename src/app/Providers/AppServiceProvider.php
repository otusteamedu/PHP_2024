<?php

namespace App\Providers;

use App\Application\Gateway\ParserUrl\ParserUrlGatewayInterface;
use App\Application\Gateway\ReportNews\ReportNewsGatewayInterface;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Factory\CommonNewsFactory;
use App\Infrastructure\Gateway\ParserUrlGateway;
use App\Infrastructure\Gateway\ReportNewsGateway;
use App\Infrastructure\Repository\DatabaseNewsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        $this->app->bind(NewsFactoryInterface::class, CommonNewsFactory::class);
        $this->app->bind(NewsRepositoryInterface::class, DatabaseNewsRepository::class);
        $this->app->bind(ReportNewsGatewayInterface::class, ReportNewsGateway::class);
        $this->app->bind(ParserUrlGatewayInterface::class, ParserUrlGateway::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use App\Application\Gateway\NewsGatewayInterface;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\ReportGenerator\ReportGeneratorInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Factory\NewsFactory;
use App\Infrastructure\Gateway\InternetNewsGateway;
use App\Infrastructure\ReportGenerator\InFileSummaryGenerator;
use App\Infrastructure\Repository\DbNewsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NewsRepositoryInterface::class, DBNewsRepository::class);
        $this->app->bind(NewsFactoryInterface::class, NewsFactory::class);
        $this->app->bind(NewsGatewayInterface::class, InternetNewsGateway::class);
        $this->app->bind(ReportGeneratorInterface::class, InFileSummaryGenerator::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

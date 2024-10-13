<?php

declare(strict_types=1);

namespace App\Providers;

use App\Application\Parser\ParserInterface;
use App\Application\Report\GeneratorInterface;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Factory\NewsFactory;
use App\Infrastructure\Parser\NewsParser;
use App\Infrastructure\Report\ReportGenerator;
use App\Infrastructure\Repository\NewsRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            NewsRepositoryInterface::class,
            NewsRepository::class
        );
        $this->app->bind(
            NewsFactoryInterface::class,
            NewsFactory::class
        );
        $this->app->bind(
            ParserInterface::class,
            NewsParser::class
        );
        $this->app->bind(
            GeneratorInterface::class,
            ReportGenerator::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Framework\Providers;

use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Repositories\NewsRepositoryInterface;
use App\Domain\Services\FileStorageServiceInterface;
use App\Domain\Services\ReportGeneratorInterface;
use App\Domain\Services\UrlParserInterface;
use App\Infrastructure\Factories\NewsFactory;
use App\Infrastructure\Repositories\NewsRepository;
use App\Infrastructure\Services\FileStorageService;
use App\Infrastructure\Services\ReportGenerator;
use App\Infrastructure\Services\UrlParser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NewsRepositoryInterface::class, NewsRepository::class);
        $this->app->bind(NewsFactoryInterface::class, NewsFactory::class);

        $this->app->bind(UrlParserInterface::class, UrlParser::class);
        $this->app->bind(ReportGeneratorInterface::class, ReportGenerator::class);
        $this->app->bind(FileStorageServiceInterface::class, FileStorageService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}

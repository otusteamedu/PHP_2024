<?php

namespace App\Framework\Providers;

use App\Application\Actions\CreateNewsActionInterface;
use App\Application\Actions\ExportNewsActionInterface;
use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Repositories\NewsRepositoryInterface;
use App\Infrastructure\Actions\CreateNewsAction;
use App\Infrastructure\Actions\ExportNewsAction;
use App\Infrastructure\Factories\NewsFactory;
use App\Infrastructure\Repositories\NewsRepository;
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

        $this->app->bind(CreateNewsActionInterface::class, CreateNewsAction::class);
        $this->app->bind(ExportNewsActionInterface::class, ExportNewsAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

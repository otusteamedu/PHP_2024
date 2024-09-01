<?php

namespace App\Infrastructure\Providers;

use App\Domain\Factories\NewsFactoryInterface;
use App\Domain\Repositories\NewsRepositoryInterface;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}

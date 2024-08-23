<?php

declare(strict_types=1);

namespace App\Infrastructure\Providers;

use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Factory\NewsFactory;
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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Provider;

use Illuminate\Support\ServiceProvider;

final class NewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom($this->getModuleMigrationPath());
        $this->app->register(NewsRouteServiceProvider::class);
    }

    protected function getModuleNamespace(): string
    {
        return 'Module\News';
    }

    protected function getModuleMigrationPath(): string
    {
        return $this->getModulePath() . DIRECTORY_SEPARATOR . 'Infrastructure/Migration';
    }

    protected function getModulePath(): string
    {
        return base_path() . DIRECTORY_SEPARATOR . str_replace('\\', '/', $this->getModuleNamespace());
    }
}

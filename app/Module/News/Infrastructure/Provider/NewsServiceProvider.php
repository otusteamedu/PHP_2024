<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Provider;

use Core\Domain\Factory\UuidFactoryInterface;
use Core\Infrastructure\Factory\UuidFactory;
use Illuminate\Support\ServiceProvider;
use Module\News\Application\Service\Interface\ReportGeneratorServiceInterface;
use Module\News\Application\Service\Interface\UrlParserServiceInterface;
use Module\News\Domain\Repository\NewsCommandRepositoryInterface;
use Module\News\Domain\Repository\NewsQueryRepositoryInterface;
use Module\News\Infrastructure\Repository\NewsCommandRepository;
use Module\News\Infrastructure\Repository\NewsQueryRepository;
use Module\News\Infrastructure\Service\HtmlReportGeneratorService;
use Module\News\Infrastructure\Service\UrlParserService;

final class NewsServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->loadMigrationsFrom($this->getModuleMigrationPath());
        $this->app->register(NewsRouteServiceProvider::class);

        $this->app->bind(UuidFactoryInterface::class, UuidFactory::class);
        $this->app->bind(NewsCommandRepositoryInterface::class, NewsCommandRepository::class);
        $this->app->bind(NewsQueryRepositoryInterface::class, NewsQueryRepository::class);
        $this->app->bind(UrlParserServiceInterface::class, UrlParserService::class);
        $this->app->bind(ReportGeneratorServiceInterface::class, HtmlReportGeneratorService::class);
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

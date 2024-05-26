<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Application;

use AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\NewsController;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\ReportController;
use Slim\App;

class RoutesInitialization
{
    public function __construct(private App $app)
    {
    }

    public function perform(): void
    {
        $this->app->post('/news', [NewsController::class, 'addNews']);
        $this->app->get('/news', [NewsController::class, 'getNews']);
        $this->app->post('/news/generate-report', [NewsController::class, 'generateReport']);
        $this->app
            ->get('/report/news/{filename}', [ReportController::class, 'getNewsReport'])
            ->setName('getNewsReport');
    }
}

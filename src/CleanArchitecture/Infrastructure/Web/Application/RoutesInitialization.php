<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Application;

use AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\News\AddNewsController;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\News\GetNewsController;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\News\GenerateNewsReportController;
use AlexanderGladkov\CleanArchitecture\Infrastructure\Web\Controller\Report\GetNewsReportController;
use Slim\App;

class RoutesInitialization
{
    public function __construct(private App $app)
    {
    }

    public function perform(): void
    {
        $this->app->post('/news', AddNewsController::class);
        $this->app->get('/news', GetNewsController::class);
        $this->app->post('/news/generate-report', GenerateNewsReportController::class);
        $this->app
            ->get('/report/news/{filename}', GetNewsReportController::class)
            ->setName('getNewsReport');
    }
}

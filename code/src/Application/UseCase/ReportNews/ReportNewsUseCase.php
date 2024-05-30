<?php

namespace App\Application\UseCase\ReportNews;

use App\Application\UseCase\ReportNews\Response\ReportNewsResponse;
use App\Domain\Repository\NewsRepositoryInterface;

class ReportNewsUseCase
{

    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getReport(): ReportNewsResponse
    {
        $response = $this->newsRepository->getLastFiveNews();
        return new ReportNewsResponse($response);
    }
}
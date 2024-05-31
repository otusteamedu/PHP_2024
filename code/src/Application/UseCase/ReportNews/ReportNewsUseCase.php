<?php

namespace App\Application\UseCase\ReportNews;

use App\Application\UseCase\ReportNews\Request\ReportNewsRequest;
use App\Application\UseCase\ReportNews\Response\ReportNewsResponse;
use App\Domain\Repository\NewsRepositoryInterface;

class ReportNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;

    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getReport(ReportNewsRequest $request): ReportNewsResponse
    {
        $response = [];
        $params = $request->request;
        foreach ($params as $id) {
            $response[] = $this->newsRepository->findById($id);
        }

        return new ReportNewsResponse($response);
    }
}
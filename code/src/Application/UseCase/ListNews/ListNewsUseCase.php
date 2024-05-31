<?php

namespace App\Application\UseCase\ListNews;

use App\Application\UseCase\ListNews\Response\ListNewsResponse;
use App\Domain\Repository\NewsRepositoryInterface;

class ListNewsUseCase
{
    private NewsRepositoryInterface $newsRepository;

    /**
     * @param NewsRepositoryInterface $newsRepository
     */
    public function __construct(NewsRepositoryInterface $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    public function getList(): ListNewsResponse
    {
        $response = $this->newsRepository->getAllNews();
        return new ListNewsResponse($response);
    }

}
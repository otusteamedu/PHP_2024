<?php

namespace App\Controller\News;

use App\News\Application\UseCase\GetAllNewsUseCase;
use App\Resource\News\NewsResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class ListAction extends AbstractController
{
    public function __invoke(
        GetAllNewsUseCase $getAllNewsUseCase,
    ): JsonResponse
    {
        $news = $getAllNewsUseCase();
        $data = [];
        foreach ($news as $newsItem) {
            $newsResource = new NewsResource($newsItem);
            $data[] = $newsResource->toArray();
        }
        return new JsonResponse($data);
    }
}
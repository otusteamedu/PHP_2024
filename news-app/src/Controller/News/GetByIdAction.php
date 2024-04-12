<?php

declare(strict_types=1);

namespace App\Controller\News;

use App\News\Application\UseCase\GetNewsByIdUseCase;
use App\Resource\News\NewsResource;
use Symfony\Component\HttpFoundation\JsonResponse;

class GetByIdAction
{
    public function __invoke(
        GetNewsByIdUseCase $getNewsByIdUseCase,
        int $id
    ): JsonResponse
    {
        $news = $getNewsByIdUseCase($id);
        $data = new NewsResource($news);
        return new JsonResponse($data->toArray());
    }
}
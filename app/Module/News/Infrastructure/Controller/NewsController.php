<?php

declare(strict_types=1);

namespace Module\News\Infrastructure\Controller;

use App\Http\Controllers\Controller;
use Module\News\Application\UseCase\Create\CreateNewsUseCase;
use Module\News\Application\UseCase\GetStatus\GetStatusRequest;
use Module\News\Application\UseCase\GetStatus\GetStatusUseCase;
use Module\News\Infrastructure\FormRequest\CreateNewsFormRequest;

final class NewsController extends Controller
{
    public function __construct(
        private readonly CreateNewsUseCase $createNews,
        private readonly GetStatusUseCase $getStatus,
    ) {
    }

    public function create(CreateNewsFormRequest $request): array
    {
        $response = ($this->createNews)($request->toUseCaseRequest());

        return ['id' => $response->id];
    }

    public function getStatus(string $id): array
    {
        $response = ($this->getStatus)(new GetStatusRequest($id));

        return ['status' => $response->status];
    }
}

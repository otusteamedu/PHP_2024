<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Http;

use Irayu\Hw15\Application;
use Irayu\Hw15\Infrastructure;
use Irayu\Hw15\Domain;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ListNewsController extends JsonController
{
    private Application\UseCase\ListNewsUseCase $useCase;

    public function __construct(Infrastructure\Repository\FileNewsRepository $repository)
    {
        $this->useCase = new Application\UseCase\ListNewsUseCase(
            $repository,
        );
    }

    protected function applyUseCase(Request $request, Response $response, array $args): array {
        $newsItemResponse = ($this->useCase)(
            new Application\UseCase\Request\ListNewsItemRequest(
                $request->getQueryParams()['pageNumber'] ?? null,
                $request->getQueryParams()['pageSize'] ?? null,
            )
        );

        return array_map(
            fn(Domain\Entity\NewsItem $item) => [
                'id' => $item->getId(),
                'url' => $item->getUrl()->getValue(),
                'title' => $item->getTitle()->getValue(),
                'date' => $item->getDate()->getValue()->format('Y-m-d'),

            ],
            $newsItemResponse->items,
        );
    }
}

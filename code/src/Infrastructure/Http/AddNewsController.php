<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Http;

use Irayu\Hw15\Application;
use Irayu\Hw15\Infrastructure;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddNewsController extends JsonController
{
    private Application\UseCase\AddNewsItemUseCase $useCase;

    public function __construct(
        Infrastructure\Factory\FirstFactory $newsFactory,
        Infrastructure\Repository\FileNewsRepository $repository,
        Infrastructure\Gateway\NewsLoader $urlLoader,
    ) {
        $this->useCase = new Application\UseCase\AddNewsItemUseCase(
            $newsFactory,
            $repository,
            $urlLoader
        );
    }

    protected function applyUseCase(Request $request, Response $response, array $args): array
    {
        $result = [
            'id' => ($this->useCase)(
                new Application\UseCase\Request\AddNewsItemRequest(
                    $request->getParsedBody()['url'],
                )
            )->id,
        ];

        $response->withStatus(201, 'Created');

        return $result;
    }
}

<?php

declare(strict_types=1);

namespace Irayu\Hw15\Infrastructure\Http;

use Irayu\Hw15\Application;
use Irayu\Hw15\Infrastructure;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AddNewsController extends JsonController
{
    private Application\UseCase\AddNewsUseCase $useCase;

    public function __construct(Infrastructure\Repository\FileNewsRepository $repository)
    {
        $this->useCase = new Application\UseCase\AddNewsUseCase(
            $repository,
        );
    }

    protected function applyUseCase(Request $request, Response $response, array $args): array
    {
        $url = $request->getParsedBody()['url'];
        $newsItemRequest = (new NewsItemLoader($url))->run();

        return [
            'id' => ($this->useCase)($newsItemRequest)->id,
        ];
    }
}
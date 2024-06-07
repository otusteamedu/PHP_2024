<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Application\UseCase\Request\CreateNewsRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class CreateNewsRequestMiddleware implements MiddlewareInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $createNewsRequest = new CreateNewsRequest((string)($data['url'] ?? ''));
        $this->container->set(CreateNewsRequest::class, $createNewsRequest);

        return $handler->handle($request);
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Application\UseCase\Request\GenerateReportRequest;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

readonly class GenerateReportRequestMiddleware implements MiddlewareInterface
{
    public function __construct(private ContainerInterface $container)
    {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = json_decode($request->getBody()->getContents(), true);
        $generateReportRequest = new GenerateReportRequest((array)($data['ids'] ?? []));
        $this->container->set(GenerateReportRequest::class, $generateReportRequest);

        return $handler->handle($request);
    }
}

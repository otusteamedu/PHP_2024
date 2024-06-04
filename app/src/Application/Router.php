<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application;

use Kagirova\Hw21\Application\Request\Request;
use Kagirova\Hw21\Application\UseCase\AddNewsUseCase;
use Kagirova\Hw21\Application\UseCase\GetNewsUseCase;
use Kagirova\Hw21\Application\UseCase\NewsUseCase;
use Kagirova\Hw21\Application\UseCase\SubscribeToCategoryUseCase;
use Kagirova\Hw21\Domain\Exception\HTTPMethodNotAllowed;
use Kagirova\Hw21\Domain\Exception\RouteNotFoundException;
use Kagirova\Hw21\Domain\RepositoryInterface\StorageInterface;

class Router
{
    public function __construct(
        private Request $request,
        private StorageInterface $storage
    ) {
    }

    public function resolve(): NewsUseCase
    {
        $this->validateMethod();
        $useCase = match ($this->request->uri[0]) {
            "add_news" => new AddNewsUseCase($this->storage, $this->request),
            "get_news" => new GetNewsUseCase($this->storage, $this->request),
            "subscribe" => new SubscribeToCategoryUseCase($this->storage, $this->request),
            default => throw new RouteNotFoundException(),
        };
        return $useCase;
    }

    private function validateMethod()
    {
        $routesMap = include_once dirname(dirname(__FILE__)) . '/../public/routes.php';

        if (!array_key_exists($this->request->method, $routesMap)) {
            throw new HTTPMethodNotAllowed();
        }

        $method_routes = $routesMap[$this->request->method];
        if (!isset($this->request->uri[0])) {
            throw new RouteNotFoundException();
        }
        if (!array_key_exists($this->request->uri[0], $method_routes)) {
            throw new RouteNotFoundException();
        }
    }
}

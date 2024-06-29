<?php

declare(strict_types=1);

namespace Kagirova\Hw31\Domain;

use _PHPStan_582a9cb8b\Nette\Neon\Exception;
use Kagirova\Hw31\Application\SenderUseCase\GetMessageUseCase;
use Kagirova\Hw31\Application\SenderUseCase\PostDataUseCase;
use Kagirova\Hw31\Domain\RepositoryInterface\StorageInterface;
use Kagirova\Hw31\Domain\Service\RabbitMqServiceInterface;

class Router
{
    public function __construct(
        private Request $request,
        private StorageInterface $storage,
        private RabbitMqServiceInterface $rabbitMqService
    ) {
    }

    public function resolve()
    {
        $this->validateMethod();
        $useCase = match ($this->request->uri[0]) {
            "get_message" => new GetMessageUseCase($this->storage, $this->request),
            "add_message" => new PostDataUseCase($this->rabbitMqService, $this->storage, $this->request),
            default => throw new Exception('Route Not Found', 404),
        };
        return $useCase;
    }

    private function validateMethod()
    {
        $routesMap = include_once dirname(dirname(__FILE__)) . '/../public/routes.php';

        if (!array_key_exists($this->request->method, $routesMap)) {
            throw new Exception('', 404);
        }

        $method_routes = $routesMap[$this->request->method];
        if (!isset($this->request->uri[0])) {
            throw new Exception('HTTP Method Not Allowed', 404);
        }
        if (!array_key_exists($this->request->uri[0], $method_routes)) {
            throw new Exception('Route Not Found', 404);
        }
    }
}

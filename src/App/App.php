<?php

namespace Komarov\Hw11\App;

use Komarov\Hw11\Exception\AppException;
use Komarov\Hw11\Storage\RedisStorage;

class App
{
    private RedisStorage $storage;
    private Router $router;

    public function __construct()
    {
        $this->storage = new RedisStorage();
        $this->router = new Router();
    }

    /**
     * @throws AppException
     */
    public function run(): void
    {
        $this->router->addRoute('POST', '/', function () {
            $data = $this->validateRequest();
            $id = $this->storage->addEvent($data);

            $this->successResponse(compact('id'));
        });

        $this->router->addRoute('POST', '/search', function () {
            $data = $this->validateRequest();
            $result = $this->storage->getBestEvent($data['params']);

            $this->successResponse($result);
        });

        $this->router->addRoute('GET', '/clear', function () {
            $this->storage->clearEvents();
        });

        $this->router->matchRoute();
    }

    /**
     * @throws AppException
     */
    private function validateRequest(): array
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (empty($data)) {
            http_response_code(400);

            throw new AppException('Bad request');
        }

        return $data;
    }

    /**
     * @param array|null $data
     * @return void
     */
    private function successResponse(?array $data): void
    {
        header('Content-type: application/json');
        http_response_code(200);

        echo json_encode([
            'success' => true,
            'data'    => $data
        ]);
    }
}

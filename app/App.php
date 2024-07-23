<?php

declare(strict_types=1);

namespace App;

use App\Http\Exceptions\HttpException;
use App\Http\Exceptions\NotFoundHttpException;
use App\Http\Request;
use App\Http\Response;
use App\Http\Router;
use App\Interfaces\EventHandlerInterface;
use RuntimeException;
use Throwable;

class App
{
    /**
     * @var EventHandlerInterface The event handler instance
     */
    public EventHandlerInterface $eventHandler;

    /**
     * @var Request The request instance
     */
    public Request $request;

    /**
     * Runs the application by dispatching the current request.
     *
     * @throws NotFoundHttpException If the route is not found.
     */
    public function run(): void
    {
        try {
            $this->registerRequest();
            $this->registerRoutes();
            $this->registerEventHandler();

            Router::dispatch(
                $this->request->method,
                $this->request->path,
                $this->request->queryParams,
                $this->request->bodyParams
            );
        } catch (HttpException $exception) {
            $response = new Response([
                'message' => $exception->getMessage(),
            ], $exception->getCode());

            $response->send();
        } catch (Throwable $exception) {
            $response = new Response([
                'message' => $exception->getMessage()
            ], 500);

            $response->send();
        }
    }

    /**
     * Registers the current request.
     */
    protected function registerRequest(): void
    {
        $this->request = new Request();
    }

    /**
     * Registers the routes for the application.
     */
    protected function registerRoutes(): void
    {
        include_once __DIR__ . '/../routes/api.php';
    }

    /**
     * Registers the event handler.
     *
     * @throws RuntimeException If no event handler is specified or if the specified handler does not exist.
     */
    protected function registerEventHandler(): void
    {
        $config = require __DIR__ . '/../config/event.php';

        if (!isset($config['default'])) {
            throw new RuntimeException('No event handler specified.');
        }

        /** @var string $handler */
        $handler = $config['default'];

        if (!isset($config['handlers'][$handler])) {
            throw new RuntimeException("Handler $handler does not exist.");
        }

        /** @var class-string<EventHandlerInterface> $service */
        $service = $config['handlers'][$handler];

        $this->eventHandler = new $service();
    }
}

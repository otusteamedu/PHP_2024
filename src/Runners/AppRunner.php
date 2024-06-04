<?php

declare(strict_types=1);

namespace App\Runners;

use App\ConnectionCreator;
use App\Handlers\RequestHandler;
use App\Producer;
use App\Requests\Request;
use App\Requests\RequestWithId;
use App\Responses\ResponseInterface;
use Exception;

class AppRunner
{
    /**
     * @throws Exception
     */
    public function run(): ResponseInterface
    {
        $connection = ConnectionCreator::create();
        $producer = new Producer($connection);
        $handler = new RequestHandler($producer);
        $request = new Request(json_decode(file_get_contents('php://input'), true));
        return $handler->handle(new RequestWithId(uniqid(), $request));
    }
}

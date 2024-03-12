<?php

declare(strict_types=1);

namespace Src\Services;

use Exception;
use Src\Controllers\ServerController;

class ChatService
{
    public function run(): void
    {
        if ($_SERVER['argc']  === 2) {
            if ($_SERVER['argv'][1] === 'start-server') {
                $serverController = new ServerController();
                $serverController->run();
            } else {
                throw new Exception('Wrong argument, excepted one of these (start-server / start-client)');
            }
        } else {
            throw new Exception('Amount of arguments is wrong, excepted 1 (start-server / start-client)');
        }
    }
}

<?php

declare(strict_types=1);

namespace App;

use App\Controller\ClientController;
use App\Controller\ServerController;
use App\Enum\ServiceCommand;
use App\Exception\SocketException;
use Exception;
use Generator;

class App
{
    /**
     * @param $argv
     * @return false|Generator
     * @throws Exception
     */
    public function run($argv): false|Generator
    {
        if (in_array(ServiceCommand::ServerStart->value, $argv)) {
            foreach ((new ServerController())->run() as $message) {
                yield $message;
            }
        }

        if (in_array(ServiceCommand::ClientStart->value, $argv)) {
            foreach ((new ClientController())->run() as $message) {
                yield $message;
            }
        }

        return false;
    }
}

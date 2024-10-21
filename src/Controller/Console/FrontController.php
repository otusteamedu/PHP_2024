<?php

declare(strict_types=1);

namespace App\Controller\Console;

use App\Controller\Enum\ServiceCommand;
use Exception;
use Generator;

class FrontController
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

<?php

declare(strict_types=1);

namespace Naimushina\ChannelManager;

use Exception;
use Generator;

class App
{
    /**
     * Запуск приложения
     * @throws Exception
     */
    public function run()
    {
        $storage = new ElasticSearchStorage();
        $storage->createIndex('new_one');
       /* $eventManager = new EventManager($storage);
        $consoleManager = new GetParamsService();
        $command = $_SERVER['argv'][1] ?? null;
        return match ($command) {
            'set' => $this->addEvent($consoleManager, $eventManager),
            'get' => $this->getEvent($consoleManager, $eventManager),
            'del' => $this->deleteAll($eventManager),
            default => throw new Exception('Unknown command "' . $command . '"')
        };*/
    }
}

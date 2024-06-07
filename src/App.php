<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\Application\HandleAsyncEvents\AsyncEventHandler;
use AKornienko\Php2024\Application\HandleUserData\UserDataHandler;
use AKornienko\Php2024\Domain\UserDataRequest\UserDataRequest;
use AKornienko\Php2024\Infrastructure\AsyncEventService;
use AKornienko\Php2024\Infrastructure\Config;
use AKornienko\Php2024\Infrastructure\RabbitClient;
use AKornienko\Php2024\Infrastructure\UserDataService;
use Exception;

class App
{
    const USER_DATA_HANDLER = 'userDataHandler';
    const ASYNC_EVENTS_LISTENER = 'asyncEventsListener';

    /**
     * @throws \Exception
     */
    public function run(): string
    {
        $config = new Config();
        $rabbitClient = new RabbitClient($config, 'users-submits');
        switch ($this->getAppType()) {
            case self::USER_DATA_HANDLER:
                $request = new UserDataRequest($_POST['name'], $_POST['email']);
                $service = new UserDataService($rabbitClient);
                return (new UserDataHandler($service))->__invoke($request);

            case self::ASYNC_EVENTS_LISTENER:
                $callback = function ($msg) {
                    print_r(PHP_EOL . ' [x] Received ' . $msg->body . PHP_EOL);
                };
                $service = new AsyncEventService($rabbitClient);
                return (new AsyncEventHandler($service))->__invoke($callback);

            default:
                return 'Please, submit your form';
        }
    }

    /**
     * @throws Exception
     */
    private function getAppType(): string
    {
        if (array_key_exists('REQUEST_METHOD', $_SERVER) && $_SERVER['REQUEST_METHOD'] === 'POST') {
            return self::USER_DATA_HANDLER;
        }
        if (array_key_exists('argv', $_SERVER) && count($_SERVER['argv']) && $_SERVER['argv'][1] === 'consumer') {
            return self::ASYNC_EVENTS_LISTENER;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return '';
        }
        throw new Exception("Wrong app request");
    }
}

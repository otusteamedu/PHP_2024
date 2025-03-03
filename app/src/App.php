<?php

namespace AnatolyShilyaev\App;

use AnatolyShilyaev\App\Application\HandleAsyncEvents\AsyncEventHandler;
use AnatolyShilyaev\App\Application\HandleUserData\UserDataHandler;
use AnatolyShilyaev\App\Domain\Request\Request;
use AnatolyShilyaev\App\Infrastructure\AsyncEventService;
use AnatolyShilyaev\App\Infrastructure\Config;
use AnatolyShilyaev\App\Infrastructure\RabbitClient;
use AnatolyShilyaev\App\Infrastructure\UserDataService;
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
                $request = new Request($_POST['dateFrom'], $_POST['dateTo']);
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
        if (array_key_exists('argv', $_SERVER) && count($_SERVER['argv']) && $_SERVER['argv'][1] === 'start') {
            return self::ASYNC_EVENTS_LISTENER;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return '';
        }
        throw new Exception("Wrong app request");
    }
}

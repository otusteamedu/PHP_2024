<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusRedisApp;

use SlavaMakhov\OtusRedisApp\Services\RedisService;
use SlavaMakhov\OtusRedisApp\Events\EventManager;
use Exception;

class App
{
    /** @var RedisService */
    private RedisService $redisService;

    public function __construct()
    {
        $this->redisService = RedisService::getInstance();
    }

    /**
     * Старт приложения
     *
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        $args = $_SERVER['argv'];
        $this->checkArgsData($args);
        $command = $args[1];
        $eventManager = new EventManager($this->redisService);

        switch ($command) {
            case 'add':
                $event = json_decode($args[2] ?? '', true);
                echo !$event ? "Неверный формат!" . PHP_EOL : $eventManager->addEvent($event);
                break;
            case 'search':
                $params = json_decode($args[2] ?? '', true);
                echo !$params ? "Неверный формат!" . PHP_EOL : $eventManager->searchEvents($params);
                break;
            case 'clear':
                echo $eventManager->clearEvents();
                break;
            default:
                throw new Exception('Команда ' . $command . ' не существует!' . PHP_EOL);
                break;
        }
    }

    /**
     * Метод проверяет введенные параметры
     * пользователем в консоли
     *
     * @throws Exception
     */
    private function checkArgsData(array $args): void
    {
        if (!isset($args[1])) {
            throw new Exception("Для дальнейшей работы, необходимо передать команду!" . PHP_EOL);
        }

        $command = $args[1];

        if ($command == 'add' || $command == 'search') {
            if (!isset($args[2])) {
                throw new Exception("Для дальнейшей работы, необходимо передать второй аргумент!" . PHP_EOL);
            }
        }
    }
}

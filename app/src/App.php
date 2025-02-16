<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusArchitectureApp;

use SlavaMakhov\OtusArchitectureApp\Infrastructure\Factory\CommonConditionListFactory;
use SlavaMakhov\OtusArchitectureApp\Infrastructure\Factory\CommonConditionFactory;
use SlavaMakhov\OtusArchitectureApp\Infrastructure\Command\SubmitEventCommand;
use SlavaMakhov\OtusArchitectureApp\Infrastructure\Factory\CommonEventFactory;
use SlavaMakhov\OtusArchitectureApp\Application\UseCase\SubmitEventRequest;
use SlavaMakhov\OtusArchitectureApp\Application\UseCase\SubmitEventUseCase;
use SlavaMakhov\OtusArchitectureApp\Infrastructure\Gateway\BaseRedisGateway;
use Exception;

class App
{
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

        switch ($command) {
            case 'add':
                $event = $args[2] ?? '';
                echo !$event ? "Неверный формат!" . PHP_EOL : $this->addEvent($event);
                break;
            default:
                throw new Exception('Команда ' . $command . ' не существует!' . PHP_EOL);
                break;
        }
    }

    /**
     * @param string|null $event
     *
     * @return string
     * @throws Exception
     */
    private function addEvent(string $event = null): string
    {
        $eventArrayData = !empty($event) ? json_decode($event, true) : null;

        if (empty($eventArrayData)) {
            throw new Exception('Error in event string');
        }

        $redisGateway = new BaseRedisGateway();
        $commonEventFactory = new CommonEventFactory();
        $commonConditionFactory = new CommonConditionFactory();
        $commonConditionListFactory = new CommonConditionListFactory();
        $submitEventUseCase = new SubmitEventUseCase($commonEventFactory, $commonConditionFactory, $commonConditionListFactory, $redisGateway);
        $submitEventCommand = new SubmitEventCommand($submitEventUseCase);
        $submitEventRequest = new SubmitEventRequest($eventArrayData['priority'], $eventArrayData['event'], $eventArrayData['conditions']);
        $result = $submitEventCommand($submitEventRequest);

        echo "Добавлено новое событие с id: " . $result->id . PHP_EOL;
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

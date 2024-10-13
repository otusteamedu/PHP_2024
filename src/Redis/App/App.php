<?php

namespace VladimirGrinko\Redis\App;

use VladimirGrinko\Redis as VGRedis;

class App
{

    public function run(): void
    {
        $this->showStartMenu();

        $startCommand = (int)readline();
        $this->handlerCmd($startCommand);
    }

    private function handlerCmd(int $command): void
    {
        switch ($command) {
            case 1:
                echo $this->cmdSet() . PHP_EOL;
                break;
            case 2:
                echo $this->cmdGet() . PHP_EOL;
                break;
            case 3:
                echo $this->cmdDel() . PHP_EOL;
                break;
            case 0:
                echo 'Bye' . PHP_EOL;
                break;
            default:
                echo 'Неизвестная команда' . PHP_EOL . PHP_EOL;
                $app = new self();
                $app->run();
                break;
        }
    }

    private function cmdSet(): string
    {
        $event = readline('Событие: ');
        $priority = (int)readline('Приоритет: ');
        $params = $this->paramsCycle();
        $eventAdd = new VGRedis\Add();
        $eventAdd->add($event, $priority, $params);
        return 'Событие добавлено';
    }

    private function cmdGet(): string
    {
        $params = $this->paramsCycle();
        $eventGet = new VGRedis\Get();
        $resEvent = $eventGet->getEvent($params);
        return $resEvent ?: 'Не найдено ни одно событие';
    }

    private function cmdDel(): string
    {
        $eventDel = new VGRedis\Delete();
        $eventDel->del();
        return 'Все события очищены';
    }

    private function paramsCycle(): array
    {
        $params = [];
        $i = 1;

        do {
            $param = readline('Параметр ' . $i . ': ');
            $value = readline('Значение параметра ' . $i . ': ');
            $params[$param] = $value;
            $i++;
            $cycleValue = readline('Для выхода введите - 0, для нового параметра введите любую клавишу: ');
        } while ($cycleValue != 0);

        return $params;
    }

    private function showStartMenu(): void
    {
        echo 'Введите команду:' . PHP_EOL .
            '1 - добавить новое событие' . PHP_EOL .
            '2 - получить событие по параметрам' . PHP_EOL .
            '3 - удалить все события' . PHP_EOL .
            '0 - выйти' . PHP_EOL;
    }
}

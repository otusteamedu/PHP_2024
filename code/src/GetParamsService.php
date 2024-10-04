<?php

namespace Naimushina\EventManager;

class GetParamsService
{

    /**
     * Запрашиваем приоритет добавляемого события
     * @return int
     */
    public function getPriorityInfo(): int
    {
        $priority = null;
        while (!is_int($priority)) {
            echo 'Введите приоритет события целым числом' . PHP_EOL;
            $input = fgets(STDIN);
            $priority = intval($input);
        }
        return $priority;
    }

    /**
     * Запрашиваем критерии добавляемого события
     * @return array
     */
    public function getParamsInfo(): array
    {
        $params = [];
        echo 'Введите  критерии возникновения' . PHP_EOL;
        $exit = false;
        while (!$exit) {
            echo 'Введите названия критерия' . PHP_EOL;
            $key = fgets(STDIN);
            echo 'Введите значение критерия' . PHP_EOL;
            $value = fgets(STDIN);
            $params[$key] = $value;
            echo 'Добавить еще критерий? да - y' . PHP_EOL;
            echo 'Либо нажмите любой другой символ для отмены' . PHP_EOL;
            $input = fgets(STDIN);
            $exit = trim($input) !== 'y';

        }
        return $params;
    }

    /**
     * Запрашиваем описание добавляемого события
     *
     * @return string
     */
    public function getEventInfo(): string
    {
        $event = null;
        while (!$event) {
            echo 'Введите описание события' . PHP_EOL;
            $input = fgets(STDIN);
            $event = $input;
        }
        return $event;
    }
}
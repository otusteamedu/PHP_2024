<?php

namespace VladimirGrinko\Rabbit\App\Service;

class TaskProcessor
{
    public function processTask(array $task): string
    {
        $startDate = $task['start_date'];
        $endDate = $task['end_date'];
        $notif = $task['notif'];

        //Эмуляция обработки данных
        sleep(10);

        //Эмуляция какого-то значения после обработки
        $value = bin2hex(random_bytes(8));

        return $value;
    }
}

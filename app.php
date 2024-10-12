<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

echo 'Введите команду:' . PHP_EOL;
echo '1 - добавить новое событие' . PHP_EOL;
echo '2 - получить событие по параметрам' . PHP_EOL;
echo '3 - удалить все события' . PHP_EOL;

$command = readline();

if ($command == 1) {
    $event = readline('Событие: ');
    $priority = (int)readline('Приоритет: ');
    $params = [];
    $i = 1;
    do {
        $param = readline('Параметр ' . $i . ': ');
        $value = readline('Значение параметра ' . $i . ': ');
        $params[$param] = $value;
        $i++;
        $exitValue = readline('Для выхода введите - 0, для нового параметра введите любую клавишу: ');
    } while ($exitValue != 0);
    $eventAdd = new VladimirGrinko\Redis\Add();
    $eventAdd->add($event, $priority, $params);
    echo 'Событие добавлено';
} elseif ($command == 2) {
    $params = [];
    $i = 1;
    do {
        $param = readline('Параметр ' . $i . ': ');
        $value = readline('Значение параметра ' . $i . ': ');
        $params[$param] = $value;
        $i++;
        $exitValue = readline('Для выхода введите - 0, для нового параметра введите любую клавишу: ');
    } while ($exitValue != 0);
    $eventGet = new VladimirGrinko\Redis\Get();
    $resEvent = $eventGet->getEvent($params);
    echo $resEvent ?: 'Не найдено ни одно событие';
} elseif ($command == 3) {
    $eventDel = new VladimirGrinko\Redis\Delete();
    echo 'Все события очищены';
} else {
    echo 'Неизвестная команда';
}
echo PHP_EOL;
<?php

declare(strict_types=1);

namespace Evgenyart\Hw12;

class OutputHelper
{
    public static function outputResultGet($data)
    {
        if (empty($data)) {
            print_r("Совпадений не найдено" . PHP_EOL);
        } else {
            print_r("Event: " . $data['event'] . "; conditions: " . self::getString($data['conditions']) . PHP_EOL);
        }
    }

    private static function getString($array)
    {
        $tmp = [];
        foreach ($array as $k => $v) {
            $tmp[] = $k . ": " . $v;
        }
        return implode(", ", $tmp);
    }

    public static function outputResultClear($data)
    {
        switch ($data) {
            case 1:
                print_r("Все события очищены" . PHP_EOL);
                break;
            case 0:
                print_r("События для очистки не найдены" . PHP_EOL);
                break;
        }
    }

    public static function outputResultAdd($data)
    {
        switch ($data) {
            case 1:
                print_r("Событие добавлено" . PHP_EOL);
                break;
            case 0:
                print_r("Событие было добавлено ранее" . PHP_EOL);
                break;
        }
    }
}

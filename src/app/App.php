<?php

declare(strict_types=1);

namespace App;

class App
{
    public static function run(): void
    {
        static::printResult([]);
    }

    public static function printResult(array $result): void
    {
        echo '<pre>';
        print_r($result);
        echo '</pre>';
    }
}

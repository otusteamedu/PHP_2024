<?php

declare(strict_types=1);

namespace App\Helpers;

class ConsoleHelper
{
    public static function output(array $data): void
    {
        print_r($data);
    }
}

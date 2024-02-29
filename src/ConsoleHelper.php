<?php

declare(strict_types=1);

namespace App;

class ConsoleHelper
{
    public static function getNotBlockingInputFromSTDIN(): string
    {
        $streams = [STDIN];
        $write = $except = null;
        $input = '';

        if (stream_select($streams, $write, $except, 0)) {
            $input = (string) fread(STDIN, 1024);
        }

        return $input;
    }
}
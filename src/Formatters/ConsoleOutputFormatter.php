<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Formatters;

class ConsoleOutputFormatter
{
    const COLOR_RED = 31;
    const COLOR_GREEN = 32;

    public function output(string $text, int $color = 32): void
    {
        echo sprintf("\e[1;37;%sm%s\e[0m", $color, $text) . PHP_EOL;
    }
}

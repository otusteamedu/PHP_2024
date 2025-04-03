<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Strategy;

class PrintTxt implements Strategy
{
    const HOW_MANY_SYMBOLS_SHOW = 50;

    public function print($content): void
    {
        print substr($content, 0, self::HOW_MANY_SYMBOLS_SHOW) . PHP_EOL;
    }
}
<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Strategy;

class PrintHtml implements Strategy
{
    const HOW_MANY_SYMBOLS_SHOW = 50;

    public function print($content): void
    {
        $clearedContent = strip_tags($content);
        $clearedContent = preg_replace(["|\s+|"], " ", $clearedContent);
        $clearedContent = trim($clearedContent);
        print substr($clearedContent, 0, self::HOW_MANY_SYMBOLS_SHOW) . PHP_EOL;
    }
}
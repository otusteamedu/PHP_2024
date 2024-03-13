<?php

declare(strict_types=1);

namespace Main;

class ConsoleLog implements LoggerInterface
{
    public function info(string $message): void
    {
        echo $message . PHP_EOL;
    }
}
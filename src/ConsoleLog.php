<?php

declare(strict_types=1);

namespace hw5;

use hw5\interfaces\LogInterface;

class ConsoleLog implements LogInterface
{
    public function info(string $msg): void
    {
        echo $msg . PHP_EOL;
    }
}

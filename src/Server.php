<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Interface\IRun;

class Server implements IRun
{
    public function run(): void
    {
        echo "\nРаботает сервер!";
    }
}

<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Interface\IRun;

class Client implements IRun
{
    public function __construct(
        // ToDo: не работает автозагрузка.
        private readonly string $stopWord,
    ) {

    }

    public function run(): void
    {
        echo "\nРаботает клиент!";
    }
}

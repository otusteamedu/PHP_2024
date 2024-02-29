<?php

declare(strict_types=1);

namespace Alogachev\Homework;

final class App
{
    public function run(): void
    {
        $config = Config::getInstance()->getConfig();
        echo 'Все хорошо. Работаем!';
    }
}

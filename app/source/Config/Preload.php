<?php

namespace Pavelsergeevich\Hw6\Config;

class Preload
{
    public function run(): void
    {
        //Подключение автолоадера
        require_once $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php';

        //Вывод ошибок
        error_reporting(0);

        $_SERVER['IS_INCLUDED_PRELOADER'] = true;
    }

}
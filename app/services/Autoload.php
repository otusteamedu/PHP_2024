<?php


namespace App\services;


class Autoload
{
    public function loadClass($className)
    {
        $file = dirname(__DIR__) . "/" .
                trim(str_replace("\\" , '/', $className),
                    "App/") .
                '.php';
            if (file_exists($file)) {
                include $file;
                return;
            }

            echo "Введено неверное имя класса";
    }

}
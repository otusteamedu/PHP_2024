<?php

declare(strict_types=1);

namespace Rrazanov\Hw4;

class App
{
    /**
     * @throws \Exception
     */
    public function run(): void
    {
        if (!empty($_POST) && key_exists('string', $_POST)) {
            $string = htmlspecialchars($_POST['string']);
            $result['brackets'] = (new Brackets())->checkBrackets($string);
        } else {
            throw new \Exception('Переданы пустые или неверные данные', 400);
        }
        $result['host'] = "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
        $result['redis'] = 'Счётчик внутри сессии ' . (new Redis())->sessionStart();
        //Просто для проверки коннекта через Docker
        $result['mysql'] = (new Mysql())->createDataTable('SELECT * FROM hw1.helloTable');
        echo '<pre>';
        var_dump($result);
        echo '</pre>';
    }
}

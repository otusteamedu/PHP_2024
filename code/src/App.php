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
        $string = '((()(((())((()))())(()))))';
        $result['brackets'] = (new Brackets())->checkBrackets($string);
        $result['host'] = "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
        $result['redis'] = 'Счётчик внутри сессии ' . (new Redis())->sessionStart();
        $result['mysql'] = (new Mysql())->createDataTable('SELECT * FROM hw1.helloTable');
        echo '<pre>';
        var_dump($result);
        echo '</pre>';
    }
}

<?php

declare(strict_types=1);

namespace Pyivanov\hw4;

use Exception;
use \InvalidArgumentException;

class App
{
    /**
     * @throws InvalidArgumentException|Exception
     */
    public function run(): void
    {
//        var_dump($_GET);die;
        if (!key_exists('string', $_GET) || empty($_GET['string'])) {
            throw new InvalidArgumentException(
                "Параметр 'string' не передан или имеет пустое значение!",
                400
            );
        }

        $result['stringValidationResult'] = (new StringValidator(str: $_GET['string']))->validate();

        $result['host'] = "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
        $result['redis'] = 'Счётчик внутри сессии ' . (new RedisCheck())->sessionStart();

        var_dump($result);
    }
}
<?php

declare(strict_types=1);

namespace Pyivanov\hw4;

use Exception;
use InvalidArgumentException;

class App
{
    /**
     * @throws InvalidArgumentException|Exception
     */
    public function run(): void
    {
        if (!key_exists('string', $_POST) || empty($_POST['string'])) {
            throw new InvalidArgumentException(
                "Параметр 'string' не передан или имеет пустое значение!",
                400
            );
        }

        $result['stringValidationResult'] = (new StringValidator(str: $_POST['string']))->validate();

        $result['host'] = "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];
        $result['redis'] = 'Счётчик внутри сессии ' . (new RedisCheck())->sessionStart();

        var_dump($result);
    }
}
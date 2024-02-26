<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use RuntimeException;

class App
{
    public function run(): void
    {
        session_start();

        echo "Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

        echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . '<br>';

        echo 'Сессия: ' . session_id() . '<br>';

        var_dump($_SERVER['REQUEST_METHOD']);
        var_dump($_POST);

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {

            echo '
            <h3>Введите строку для валидации скобочек:</h3>
            <form method="post">
                    <input type="text" name="string" value="(()()()()))((((()()()))(()()()(((()))))))">
                    <input type="submit" name="submit" value="submit">
                </form>
            ';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            try {
                (new BracketsChecker())->check($_POST['string'] ?? null);
            } catch (RuntimeException $exception) {
                header("HTTP/1.1 400 BAD REQUEST", true, 400);
                echo $exception->getMessage() . '<br>';
            }

        }
    }
}

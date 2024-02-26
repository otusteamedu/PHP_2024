<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use RuntimeException;

class App
{
    public function run(): void
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->helloView();

            echo '
            <h3>Введите строку для валидации скобочек:</h3>
            <form method="post">
                    <input type="text" name="string" value="()">
                    <input type="submit" name="submit" value="submit">
                </form>
            ';
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
            try {
                $string = $_POST['string'] ?? null;
                (new BracketsChecker())->check($string);
                header('HTTP/1.1 200 OK', true, 200);
                echo '200 OK <br>';
                echo 'Строка ' . $string . ' валидна<br>';
            } catch (RuntimeException $exception) {
                header('HTTP/1.1 400 BAD REQUEST', true, 400);
                $this->helloView();
                echo '400 Bad Request <br>';
                echo $exception->getMessage() . '<br>';
            }

        }
    }

    private function helloView(): void
    {
        echo 'Привет, Otus!<br>' . date('Y-m-d H:i:s') . '<br><br>';

        echo 'Запрос обработал контейнер: ' . $_SERVER['HOSTNAME'] . '<br>';

        echo 'Сессия: ' . session_id() . '<br>';
    }
}

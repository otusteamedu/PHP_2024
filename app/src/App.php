<?php

declare(strict_types=1);

namespace Lrazumov\Hw4;

class App
{
    public function run()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return '
                <h1>(()()()())<span style="color:red;">)</span>((((()()()))(()()()(((()))))))</h1>
                <form method="post">
                    <input type="text" name="string">
                    <input type="submit" value="Check">
                </form>
                <h2>Balance info</h2>
                <b>Nginx:</b> ' . $_SERVER['HTTP_X_NGINX'] . '<br>
                <b>Php-fpm:</b> ' . $_SERVER['HOSTNAME'] . '<br>
            ';
        }
        elseif (
            (new BracketsChecker())->check($_POST['string'] ?? '')
        ) {
            header("HTTP/1.1 200 OK", true, 200);
            return '200 Ok!';
        }
        header("HTTP/1.1 400 BAD REQUEST", true, 400);
        return '400 Bad!';
    }
}

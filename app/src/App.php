<?php

declare(strict_types=1);

namespace Lrazumov\Hw4;

class App
{
    public function run()
    {
        session_start([
            'save_handler' => 'redis', 
            'save_path' => 'tcp://redis:6379?auth=' . getenv("REDIS_PASSWORD")
        ]);
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $redis = new \Redis();
            $redis->connect('redis', 6379);
            $redis->auth(
                getenv("REDIS_PASSWORD")
            );
            $count = isset($_SESSION['count']) ? $_SESSION['count'] : 1;
            $_SESSION['count'] = ++$count;
            return '
                <h1>(()()()())<span style="color:red;">)</span>((((()()()))(()()()(((()))))))</h1>
                <form method="post">
                    <input type="text" name="string">
                    <input type="submit" value="Check">
                </form>
                <h2>Balance info</h2>
                <b>Nginx:</b> ' . $_SERVER['HTTP_X_NGINX'] . '<br>
                <b>Php-fpm:</b> ' . $_SERVER['HOSTNAME'] . '<br>
                <b>Redis:</b> ' . ($redis->ping() ? 'ok' : 'fail') . '<br>
                <b>Session counter:</b> ' . $count . '<br>
            ';
        } elseif (
            (new BracketsChecker())->check($_POST['string'] ?? '')
        ) {
            header("HTTP/1.1 200 OK", true, 200);
            return '200 Ok!';
        }
        header("HTTP/1.1 400 BAD REQUEST", true, 400);
        return '400 Bad!';
    }
}

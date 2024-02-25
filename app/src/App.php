<?php

declare(strict_types=1);

namespace Lrazumov\Hw4;

class App
{
    public function run()
    {
        $app_ip = getenv("APP_IP");
        session_start([
            'save_handler' => 'rediscluster',
            'save_path' => http_build_query([
                'seed' => [
                    $app_ip . ':6381',
                    $app_ip . ':6382',
                    $app_ip . ':6383',
                    $app_ip . ':6384',
                    $app_ip . ':6385',
                    $app_ip . ':6386',
                ],
                'timeout' => 2,
                'read_timeout' => 10,
                'failover' => 'error',
                'auth' => getenv("REDIS_PASSWORD"),
            ]),
        ]);
        $_SESSION['count'] = 1;
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
                <b>Session counter:</b> ' . session_id() . '<br>
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

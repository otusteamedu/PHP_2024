<?php

namespace Core;

use Redis;
use Core\Router;

class App
{
    public function run()
    {
        $redis = new Redis();

        if ($redis->connect('redis', 6379) && $redis->select(0)) {
            $handler = new \Core\RedisSessionHandler($redis);
            session_set_save_handler($handler);
        }

        session_start();

        if (!isset($_SESSION['key'])) {
            $_SESSION['key'] = md5(strtotime(date('Y-m-d H:i:s')));
        }

        Router::start();
    }
}
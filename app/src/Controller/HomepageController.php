<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\RedisService;

class HomepageController
{
    /**
     * @return string
     * @throws \RedisException
     */
    public function homepage(): string
    {
        $checkRedisResult = (new RedisService())->checkRedis();

        return "It works!<br>" . date("Y-m-d H:i:s") . "<br><br>"
              . "Запрос обработал PHP-контейнер: " . $_SERVER['HOSTNAME'] . "<br>"
              . "Запрос обработал nginx: " . $_SERVER['SERVER_ADDR'] . "<br><br>"
              . ($checkRedisResult['connect'] ? 'Redis: коннект установлен' : 'Redis: коннект отсутствует') . '<br>'
              . ($checkRedisResult['auth'] ? 'Redis: авторизация выполнена' : 'Redis: в доступе отказано') . '<br><br>'
              . 'Для проверки скобочной последовательности отправьте POST запрос по адресу http://app.local/api';
    }
}

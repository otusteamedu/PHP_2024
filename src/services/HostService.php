<?php

namespace services;

class HostService
{
    /**
     * @return string
     */
    public function getHostanmeMessgae(): string
    {
        return "Контейнер: {$_SERVER['HOSTNAME']}" . PHP_EOL . "Сервер: {$_SERVER['SERVER_ADDR']}" . PHP_EOL;
    }
}

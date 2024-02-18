<?php

namespace services;

class HostService
{
    /**
     * @return string
     */
    public function getHostanmeMessgae(): string
    {
        return  "Контейнер: {$_SERVER['HOSTNAME']}" . PHP_EOL;
    }
}

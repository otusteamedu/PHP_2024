<?php

namespace services;

class HostService
{
    /**
     * @return string
     */
    public function getHostanmeMessgae(): string
    {
        return  "<br><br>Контейнер: {$_SERVER['HOSTNAME']}<br>";
    }
}

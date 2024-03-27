<?php
declare(strict_types=1);

namespace App\Services\Config;

abstract class Config
{
    const CONFIG_PATH = __DIR__.'/../../config/config.ini';
    const SOCKET_PATH = 'SOCKET_PATH';
    const SOCK_CONST_SECTION = 'Socket_constants';

    public static function getSocketPath() {
        $config = parse_ini_file(self::CONFIG_PATH);
        if (array_key_exists(self::SOCKET_PATH,$config)) return $config[self::SOCKET_PATH];
        else throw new \ErrorException("Fatal error");
    }

    public static function getSockConst(string $name) {
        $config = parse_ini_file(self::CONFIG_PATH,true);
        $constSec = self::SOCK_CONST_SECTION;
        if (array_key_exists($constSec,$config)) {
            if (array_key_exists($name,$config[$constSec]))
                return $config[$constSec][$name];
        }
        return '';
    }

}
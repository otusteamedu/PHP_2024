<?php

namespace Evgenyart\UnixSocketChat;

use Evgenyart\UnixSocketChat\Exceptions\ConfigException;

class Config
{
    const CONFIG_PATH = __DIR__  . "/../config.ini";

    public static function load($path = self::CONFIG_PATH)
    {
        if (!file_exists($path)) {
            throw new ConfigException("No isset config.ini");
        }

        $arSections = parse_ini_file($path);

        if (!isset($arSections['socket_path'])) {
            throw new ConfigException("No isset socket_path in config.ini");
        }

        if (!strlen($arSections['socket_path'])) {
            throw new ConfigException("Empty value socket_path in config.ini");
        }

        return $arSections['socket_path'];
    }
}

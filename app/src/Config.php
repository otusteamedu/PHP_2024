<?php

namespace Evgenyart\UnixSocketChat;

use Exception;

class Config
{
    const CONFIG_PATH = "/../config.ini";

    public static function load()
    {
        if (!file_exists(__DIR__  . self::CONFIG_PATH)) {
            throw new Exception("No isset config.ini");
        }

        $arSections = parse_ini_file(__DIR__  . self::CONFIG_PATH);

        if (!isset($arSections['socket_path'])) {
            throw new Exception("No isset socket_path in config.ini");
        }

        if (!strlen($arSections['socket_path'])) {
            throw new Exception("Empty value socket_path in config.ini");
        }

        return $arSections['socket_path'];
    }
}

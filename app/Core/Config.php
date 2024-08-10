<?php

namespace App\Core;

class Config
{
    private static array $config;

    public static function get(string $category, string $key, mixed $default = null): mixed
    {
        if (!isset(self::$config)) {
            self::loadConfigs();
        }

        return self::$config[$category][$key] ?? $default;
    }

    private static function loadConfigs(string $dir = __ROOT__ . '/config'): void
    {
        $files = glob("$dir/*.php");

        foreach ($files as $file) {
            $key = pathinfo($file, PATHINFO_FILENAME);
            $values = require_once $file;

            self::$config[$key] = $values;
        }
    }
}

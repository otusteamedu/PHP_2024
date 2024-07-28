<?php

declare(strict_types=1);

function config(string $key, $default = null): mixed
{
    $config = require __DIR__ . '/../config/main.php';

    return $config[$key] ?? $default;
}

function env(string $key, $default = null): mixed
{
    $envData = [];

    $path = __DIR__ . DIRECTORY_SEPARATOR . '../../../.env';

    if (!file_exists($path)) {
        throw new InvalidArgumentException(sprintf('Файл конфигурации %s не найден', $path));
    }


    if (!is_readable($path)) {
        throw new RuntimeException(sprintf('Не удалось прочитать файл %s', $path));
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);

        $name = trim($name);
        $value = trim($value);

        if (!strlen($name) || !strlen($value)) {
            continue;
        }

        $envData[$name] = $value;
    }

    return $envData[$key] ?? null;
}

function dashesToCamelCase($string, $capitalizeFirstCharacter = false): string
{
    $str = str_replace('-', '', ucwords($string, '-'));

    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }

    return $str;
}

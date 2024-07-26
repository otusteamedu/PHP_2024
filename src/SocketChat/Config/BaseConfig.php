<?php

declare(strict_types=1);

namespace AlexanderGladkov\SocketChat\Config;

use Exception;

abstract class BaseConfig
{
    protected array $config;

    /**
     * @param $filename
     * @throws Exception
     */
    public function __construct($filename)
    {
        if (!file_exists($filename)) {
            throw new Exception("Файл конфигурации $filename не найден!");
        }

        $this->config = parse_ini_file($filename, true);
        if ($this->config === false) {
            throw new Exception('Некорректный файл конфигурации!');
        }
    }
}

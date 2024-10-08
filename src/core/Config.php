<?php

namespace Ali\Socket;

use Exception;

class Config
{
    private array $config;

    public function __construct(string $file)
    {
        if (!file_exists($file)) {
            throw new Exception("Файл конфигурации не найден: $file");
        }

        $this->config = parse_ini_file($file);
        if ($this->config === false) {
            throw new Exception("Ошибка при загрузке файла конфигурации: $file");
        }
    }

    public function get(string $key)
    {
        return $this->config[$key] ?? null;
    }

    public function getAll(): array
    {
        return $this->config;
    }
}

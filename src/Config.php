<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Dotenv\Dotenv;

final class Config
{
    private array $configs = [];
    private static ?self $instance = null;


    public static function getInstance(): self
    {
        if (is_null(Config::$instance)) {
            Config::$instance = new self();
        }

        return Config::$instance;
    }

    private function loadConfig()
    {
        $configPath = $_ENV['CONFIG_PATH'];
        if (!file_exists($configPath)) {
            // ToDo: Выбросить исключение NonExistedConfigException.
        }

        $config = parse_ini_file($configPath, true);

        if ($config === false) {
            // ToDo: Выбросить исключение WrongConfigException.
        }

        return $config;
    }

    private function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__);
        $dotenv->load();

        $config = $this->loadConfig();
        $this->configs = $config;
    }
    private function __clone() {}
    private function __wakeup() {}
}

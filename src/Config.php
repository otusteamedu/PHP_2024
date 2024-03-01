<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\NonExistedConfigException;
use Alogachev\Homework\Exception\WrongConfigException;
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

    public function getConfig(): array
    {
        return $this->configs;
    }

    private function loadConfig(): array
    {
        $configPath = dirname(__DIR__) . $_ENV['CONFIG_PATH'];
        if (!file_exists($configPath)) {
            throw new NonExistedConfigException();
        }

        $config = parse_ini_file($configPath, true);

        if ($config === false) {
            throw new WrongConfigException();
        }

        return $config;
    }

    private function __construct()
    {
        // ToDo: Вынести отсюда.
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $config = $this->loadConfig();
        $this->configs = $config;
    }
    private function __clone() {}
}

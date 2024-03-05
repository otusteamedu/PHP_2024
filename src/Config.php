<?php

declare(strict_types=1);

namespace Alogachev\Homework;

use Alogachev\Homework\Exception\NonExistedConfigException;
use Alogachev\Homework\Exception\WrongConfigException;

final class Config
{
    private string $socketPath;
    private string $stopWord;

    public function __construct()
    {
        $config = $this->loadConfig();
        $this->socketPath = $config['socket']['path'] ?? '';
        $this->stopWord = $config['socket']['stop_word'] ?? '';
    }

    public function getSocketPath(): string
    {
        return $this->socketPath;
    }

    public function getStopWord(): string
    {
        return $this->stopWord;
    }

    private function loadConfig(): array
    {
        $configPath = $_ENV['CONFIG_PATH'];
        if (!file_exists($configPath)) {
            throw new NonExistedConfigException();
        }

        $config = parse_ini_file($configPath, true);

        if ($config === false) {
            throw new WrongConfigException();
        }

        return $config;
    }
}

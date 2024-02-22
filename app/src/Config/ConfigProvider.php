<?php

declare(strict_types=1);

namespace Kiryao\Sockchat\Config;

use Kiryao\Sockchat\Config\Exception\ConfigNotFoundException;

class ConfigProvider implements ConfigProviderInterface
{
    private const CONFIG_FILE_PATH = __DIR__ . '/../../config/config.ini';

    public function __construct()
    {
    }

    /**
     * @throws ConfigNotFoundException
     */
    public function load(string $configHeader): array
    {
        $config = parse_ini_file(self::CONFIG_FILE_PATH, true);

        if ($config === false) {
            throw new ConfigNotFoundException('Config file not found in ' . self::CONFIG_FILE_PATH);
        }

        $config = $config[$configHeader];

        foreach ($config as $key => $value) {
            $config[$key] = $this->normalizeValue($value);
        }

        return $config;
    }

    private function normalizeValue($value): string|int
    {
        return is_numeric($value) ? (int) $value : (string) $value;
    }
}

<?php

declare(strict_types=1);

namespace Viking311\Chat\Config;

class Config
{
    private array $cfg;

    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../app.ini');
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app ini file');
        }
        $this->cfg = $cfg;
    }

    /**
     * @param string $key
     *
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return $this->cfg[$key] ?? null;
    }
}

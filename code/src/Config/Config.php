<?php

declare(strict_types=1);

namespace Viking311\Books\Config;

class Config
{

    public readonly string $host;
    public readonly string $user;
    public readonly string $password;
    public readonly string $caCert;
    public readonly string $index;

    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../app.ini');
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app ini file');
        }

        if (!array_key_exists('host', $cfg) || empty($cfg['host'])) {
            throw new ConfigException('Elastic host is not set');
        }

        $this->host = $cfg['host'];
        $this->user = $cfg['user'] ?? '';
        $this->password = $cfg['password'] ?? '';

        $this->caCert = $cfg['caCert'] ?? '';

        if (!array_key_exists('index', $cfg) || empty($cfg['index'])) {
            throw new ConfigException('Elastic index is not set');
        }
        $this->index = $cfg['index'];
    }
}

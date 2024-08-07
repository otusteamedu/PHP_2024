<?php

declare(strict_types=1);

namespace Viking311\Analytics\Config;

class Config
{
    public readonly string $registryAdapter;
    public readonly string $redisHost;
    public readonly int $redisPort;
    public readonly string $memcachedHost;
    public readonly int $memcachedPort;

    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../app.ini', true);
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app.ini file');
        }

        if (!array_key_exists('registry', $cfg) || !is_array($cfg['registry'])) {
            throw new ConfigException('Registry section not found in app.ini file');
        }
        if (!array_key_exists('adapter', $cfg['registry'])) {
            throw new ConfigException('Registry.adapter parameter not found in app.ini file');
        }
        $this->registryAdapter = $cfg['registry']['adapter'];

        if (!array_key_exists('redis', $cfg) && !array_key_exists('memcached', $cfg)) {
            throw new ConfigException('No one storage system is configured  in app.ini file');
        }

        if (array_key_exists('redis', $cfg)) {
            if (!is_array($cfg['redis'])) {
                throw new ConfigException('Redis section not found in app.ini file');
            }
            $this->readRedisConfig($cfg['redis']);
        }

        if (array_key_exists('memcached', $cfg)) {
            if (!is_array($cfg['memcached'])) {
                throw new ConfigException('Memcached section not found in app.ini file');
            }
            $this->readMemcachedConfig($cfg['memcached']);
        }
    }

    /**
     * @param array $cfg
     * @return void
     * @throws ConfigException
     */
    private function readRedisConfig(array $cfg): void
    {
        if (!array_key_exists('host', $cfg)) {
            throw new ConfigException('Redis.host parameter not found in app.ini file');
        }
        $this->redisHost = $cfg['host'];

        $this->redisPort = isset($cfg['port']) ? (int) $cfg['port'] : 6379;
    }

    /**
     * @param array $cfg
     * @return void
     * @throws ConfigException
     */
    private function readMemcachedConfig(array $cfg): void
    {
        if (!array_key_exists('host', $cfg)) {
            throw new ConfigException('Memcached.host parameter not found in app.ini file');
        }
        $this->memcachedHost = $cfg['host'];

        $this->memcachedPort = isset($cfg['port']) ? (int) $cfg['port'] : 11211;
    }
}

<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Config\ConfigItem;

use Viking311\Api\Infrastructure\Config\ConfigException;

readonly class RedisConfig
{
    /** @var string     */
    public string $redisHost;
    /** @var integer */
    public int $redisPort;

    public function __construct(array $cfg)
    {
        if (!array_key_exists('host', $cfg)) {
            throw new ConfigException('Redis.host parameter not found in app.ini file');
        }
        $this->redisHost = $cfg['host'];

        $this->redisPort = isset($cfg['port']) ? (int) $cfg['port'] : 6379;
    }
}

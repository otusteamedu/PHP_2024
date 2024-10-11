<?php

declare(strict_types=1);

namespace Viking311\Api\Infrastructure\Config;

use Viking311\Api\Infrastructure\Config\ConfigItem\RabbitMqConfig;
use Viking311\Api\Infrastructure\Config\ConfigItem\RedisConfig;

class Config
{
    /** @var RabbitMqConfig  */
    public RabbitMqConfig $rabbitMq;
    /** @var RedisConfig  */
    public RedisConfig $redis;

    /**
     * @throws ConfigException
     */
    public function __construct()
    {
        $cfg = parse_ini_file(__DIR__ . '/../../../app.ini', true);
        if ($cfg === false) {
            throw new ConfigException('Cannot parse app.ini file');
        }

        if (array_key_exists('rabbit', $cfg) && !is_array($cfg['rabbit'])) {
            throw new ConfigException('Rabbit must be section');
        } else {
            $this->rabbitMq = new RabbitMqConfig(
                $cfg['rabbit'] ?? []
            );
        }
        if (array_key_exists('redis', $cfg) && !is_array($cfg['redis'])) {
            throw new ConfigException('Redis section not found in app.ini file');
        } else {
            $this->redis = new RedisConfig($cfg['redis']);
        }
    }
}

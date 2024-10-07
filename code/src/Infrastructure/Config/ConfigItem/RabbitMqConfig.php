<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Config\ConfigItem;

class RabbitMqConfig
{
    /** @var string */
    public string $host = 'localhost';
    /** @var int  */
    public int $port = 5672;
    /** @var string  */
    public string $user = 'guest';
    /** @var string  */
    public string $password = 'guest';
    /** @var string  */
    public string $queue = 'events';

    public function __construct(array $cfg)
    {
        if (array_key_exists('host', $cfg)) {
            $this->host = $cfg['host'];
        }

        if (array_key_exists('port', $cfg)) {
            $this->port = (int)$cfg['port'];
        }

        if (array_key_exists('user', $cfg)) {
            $this->user = $cfg['user'];
        }

        if (array_key_exists('password', $cfg)) {
            $this->password = $cfg['password'];
        }

        if (array_key_exists('password', $cfg)) {
            $this->password = $cfg['password'];
        }

        if (array_key_exists('queue', $cfg)) {
            $this->queue = $cfg['queue'];
        }
    }
}

<?php

declare(strict_types=1);

namespace Viking311\Queue\Infrastructure\Config\ConfigItem;

class RabbitMqConfig
{
    /** @var string */
    public string $host;
    /** @var int  */
    public int $port;
    /** @var string  */
    public string $user;
    /** @var string  */
    public string $password;
    /** @var string  */
    public string $queue;

    public function __construct(array $cfg)
    {
        $this->host = $cfg['host'] ?? 'localhost';
        $this->port = array_key_exists('port', $cfg) ? (int) $cfg['port'] : 5672;
        $this->user = $cfg['user'] ?? 'guest';
        $this->password = $cfg['password'] ?? 'guest';
        $this->queue = $cfg['queue'] ?? 'events';
    }
}

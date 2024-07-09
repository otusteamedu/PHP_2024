<?php

declare(strict_types=1);

namespace App\Infrastructure\Async\RabbitMQ;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionManager
{
    private string $host;
    private int $port;
    private string $user;
    private string $password;
    private string $vhost;

    public function __construct()
    {
        $this->host = $_ENV['RABBITMQ_HOST'] ?? 'localhost';
        $this->port = (int) $_ENV['RABBITMQ_PORT'] ?? 5672;
        $this->user = $_ENV['RABBITMQ_DEFAULT_USER'] ?? 'guest';
        $this->password = $_ENV['RABBITMQ_DEFAULT_PASS'] ?? 'guest';
        $this->vhost = $_ENV['RABBITMQ_VHOST'] ?? '/';
    }

    public function getConnection(): AMQPStreamConnection
    {
        return new AMQPStreamConnection(
            $this->host,
            $this->port,
            $this->user,
            $this->password,
            $this->vhost
        );
    }
}

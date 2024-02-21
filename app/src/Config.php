<?php

declare(strict_types=1);

namespace AlexanderPogorelov\Chat;

class Config
{
    public const MAX_MESSAGE_LENGTH = 'max_message_length';
    public const STOP_MESSAGE = 'stop_message';
    public const SOCKET_PATH = 'socket_path';

    private array $data;

    public function __construct()
    {
        $data = parse_ini_file(dirname(__DIR__) . '/config.ini');

        if (false === $data) {
            throw new \RuntimeException('Unable to parse config.ini');
        }

        $this->data = $data;
    }

    public function getMaxMessageLength(): int
    {
        return (int) $this->data[self::MAX_MESSAGE_LENGTH];
    }

    public function getStopMessage(): string
    {
        return $this->data[self::STOP_MESSAGE];
    }

    public function getSocketPath(): string
    {
        return $this->data[self::SOCKET_PATH];
    }
}

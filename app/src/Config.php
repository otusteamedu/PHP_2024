<?php

declare(strict_types=1);

namespace Kagirova\Hw5;

class Config
{
    const SOCKET_PATH_PARAM = 'socket_path';
    const MESSAGE_MAX_LENGTH_PARAM = 'message_max_length';

    private string $socketPath;
    private int $messageMaxLength;

    private function __construct(string $socketPath, int $messageMaxLength)
    {
        $this->socketPath = $socketPath;
        $this->messageMaxLength = $messageMaxLength;
    }

    public function getSocketPath(): string
    {
        return $this->socketPath;
    }


    public function getMessageMaxLength(): int
    {
        return $this->messageMaxLength;
    }

    public static function create(): Config
    {
        $data = parse_ini_file(dirname(__DIR__) . '/app.ini');

        return new Config(
            $data[Config::SOCKET_PATH_PARAM],
            (int)$data[Config::MESSAGE_MAX_LENGTH_PARAM]
        );
    }
}

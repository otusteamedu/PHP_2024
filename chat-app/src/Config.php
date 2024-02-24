<?php

declare(strict_types=1);

namespace Sfadeev\ChatApp;

use RuntimeException;

class Config
{
    const SOCKET_PATH_PARAM = 'socket_path';
    const MESSAGE_MAX_LENGTH_PARAM = 'message_max_length';

    private string $socketPath;
    private int $messageMaxLength;

    /**
     * @param string $socketPath
     * @param int $messageMaxLength
     */
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

    /**
     * @param string $projectDir
     * @return Config
     */
    public static function create(string $projectDir): Config
    {
        $config = parse_ini_file($projectDir . '/config/app.ini');

        return new Config(
            self::parsePath($config[Config::SOCKET_PATH_PARAM], $projectDir),
            self::parseInt($config[Config::MESSAGE_MAX_LENGTH_PARAM]),
        );
    }

    /**
     * @param string $value
     * @param string $projectDir
     * @return string
     */
    private static function parsePath(string $value, string $projectDir): string
    {
        return str_replace("%project.dir%", $projectDir, $value);
    }

    /**
     * @param string $value
     * @return int
     *
     * @throws RuntimeException
     */
    private static function parseInt(string $value): int
    {
        if (false === ($maxMessageLength = filter_var($value, FILTER_VALIDATE_INT))) {
            throw new RuntimeException(sprintf('Invalid configuration param "%s": "%s"', 'message_max_length', Config::MESSAGE_MAX_LENGTH_PARAM));
        }

        return $maxMessageLength;
    }
}

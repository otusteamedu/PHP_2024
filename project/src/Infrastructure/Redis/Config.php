<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Redis;

use RuntimeException;

class Config
{
    const HOST_PARAM = 'host';
    const PORT_PARAM = 'port';

    private string $host;
    private int $port;

    private function __construct(string $host, int $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            self::HOST_PARAM => $this->host,
            self::PORT_PARAM => $this->port,
        ];
    }

    public static function create(string $projectDir): Config
    {
        $config = parse_ini_file($projectDir . '/config/redis.ini');

        return new Config(
            $config[Config::HOST_PARAM],
            self::parseInt($config[Config::PORT_PARAM], Config::PORT_PARAM),
        );
    }

    private static function parseInt(string $value, string $name): int
    {
        if (false === ($intVal = filter_var($value, FILTER_VALIDATE_INT))) {
            throw new RuntimeException(sprintf('Invalid configuration param "%s": "%s"', $name, $value));
        }

        return $intVal;
    }
}

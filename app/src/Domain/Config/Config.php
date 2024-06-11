<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Domain\Config;

use Kagirova\Hw21\Domain\Exception\InvalidArgumentException;

class Config
{
    private readonly string $host;
    private readonly string $port;
    private readonly string $database;
    private readonly string $user;
    private readonly string $password;
    public function __construct(private string $path)
    {
    }

    public function configPostgres()
    {
        $params = parse_ini_file($this->path);
        if ($params === false) {
            throw new \Exception("Error reading database configuration file");
        }
        $this->ensureCorrectParams($params);
        $this->host = $params['host'];
        $this->port = $params['port'];
        $this->database = $params['database'];
        $this->user = $params['user'];
        $this->password = $params['password'];
        return $params;
    }

    private function ensureCorrectParams(array $params): void
    {
        if (
            !isset($params['database']) ||
            !isset($params['host']) ||
            !isset($params['port']) ||
            !isset($params['user']) ||
            !isset($params['password'])
        ) {
            throw new InvalidArgumentException();
        }
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

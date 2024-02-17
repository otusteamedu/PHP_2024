<?php

declare(strict_types=1);

namespace App\Services;

use Memcached;

final readonly class MemcachedService
{
    private Memcached $memcached;
    private array $env;

    public function __construct(private string $envPath)
    {
        $this->env = parse_ini_file($this->envPath) ?? [];
        $this->memcached = new Memcached();
        $this->memcached->addServer("memcache", (int)$this->env['MEMCACHED_PORT']);
    }

    public function getSessionId(): void
    {
        echo 'Session id: ' . session_id() . '<br>';
    }
}

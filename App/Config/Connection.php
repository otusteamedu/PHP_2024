<?php

namespace App\Config;

use Memcached;
use PDO;
use PDOException;
use Predis\Client;

final readonly class Connection
{
    private Client $predis;
    private PDO $mysql;
    private Memcached $memcached;
    private array $env;

    public function __construct(private string $envPath)
    {
        $this->env = parse_ini_file($this->envPath) ?? [];
        $this->loadPredisConfig();
        $this->loadMySqlConfig();
        $this->loadMemcachedConfig();
    }

    public function test(): void
    {
        echo $this->predis->get('test_connection') . '<br>';
        $result = $this->mysql->query('SELECT database() as db')->fetchObject();
        echo "Mysql db:$result->db connect success!" . '<br>';
        echo $this->memcached->get("test_connection") . '<br>';
    }

    private function loadPredisConfig(): void
    {
        $this->predis = new Client([
            'scheme' => 'tcp',
            'host' => 'redis',
            'port' => $this->env['REDIS_PORT'],
            'password' => ''
        ]);

        $this->predis->set('test_connection', 'Predis connect success!');
    }

    private function loadMySqlConfig(): void
    {
        $dbName = $this->env['MYSQL_DATABASE'];

        try {
            $this->mysql = new PDO(
                "mysql:host=mysql;dbname=$dbName",
                $this->env['MYSQL_USER'],
                $this->env['MYSQL_PASSWORD'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $ex) {
            echo 'MySql connect filed';
        }
    }

    private function loadMemcachedConfig(): void
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer("memcache", $this->env['MEMCACHED_PORT']);
        $this->memcached->set('test_connection', 'Memcached connect success!');
    }

}
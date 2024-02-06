<?php

declare(strict_types=1);

require 'vendor/autoload.php';

$redis = new Redis();
$redis->connect('redis', 6379);
if ($redis->ping()) {
    echo "Redis is running successfully" . "<br/>";
}

try {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=hw1', 'otus', 'otus');
    echo "Postgres is running successfully" . "<br/>";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
$memcached->set("ping", "Memcached is running successfully");
echo $memcached->get("ping") . "<br/>";

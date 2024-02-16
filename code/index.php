<?php

$redis = new Redis();
$redis->connect('redis', 6379);
if ($redis->ping()) {
    echo "Redis is running" . "<br/>";
}

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
$memcached->set("ping", "Memcached is running");
echo $memcached->get("ping") . "<br/>";

try {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=example', 'root', '1q2w3e4r5t');
    echo "Postgres is running" . "<br/>";
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int) $e->getCode());
}

phpinfo();
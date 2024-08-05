<?php

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
$memcached->set("ping", "Memcached - OK");
echo $memcached->get("ping") . "<br/>";


try {
    $redis = new Redis();
    $redis->connect('redis');
    if ($redis->ping()) {
        echo "Redis - OK" . "<br/>";
    }
} catch (RedisException $e) {
    echo 'Redis - NOT OK';
}


try {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=postgres', 'postgres_user', 'password');
    echo 'Postgres - OK';
} catch (Exception $e) {
    echo 'Postgres - NOT OK';
}

<?php

echo 'Время для тестирования ' . date("H:i:s") . '<br>';

echo 'Redis - ';

$redis = new Redis();
try {
    $redis->connect('redis', 6379);
    echo $redis->ping('Redis is working') . '<br/>';
} catch (RedisException $e) {
    echo 'Ошибка подключения к Redis - ' . $e->getMessage() . '<br/>';
}

echo 'Memcached - ';

$memcached = new Memcached();
$memcachedConnection = $memcached->addServer("memcached", 112712);

if ($memcachedConnection) {
    echo 'Memcached is working <br/>';
} else {
    echo 'Memcached is not working <br/>';
}


try {
    $dsn = 'pgsql:host=postgres;port=5432;dbname=otus';
    $dbh = new PDO($dsn, 'otus', 'otus');

    $query = $dbh->query('SELECT * FROM users');
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    echo '<pre>';
    var_dump($users);
    echo '</pre>';
} catch (PDOException $e) {
    echo 'Ошибка подключения к PostgreSQL - ' . $e->getMessage() . '<br/>';
}

phpinfo();

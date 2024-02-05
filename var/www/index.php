<?php

//redis
try {
    $redis = new Redis();
    $redis->connect('redis', getenv("REDIS_PORT"));
    $redis->auth(getenv("REDIS_PASSWORD"));
    echo "Redis подключение успешно ping:" . $redis->ping() . "<br>";
    $redis->close();
} catch (Throwable $e) {
    echo "Ошибка подключение к Redis:" . "<br>" . $e->getMessage() . "<br>";
}

//Memcached
try {
    $memcahed = new \Memcached();
    $memcahed->addServer('memcached', getenv("MEMCACHED_PORT"));
    echo "Memcached подключение успешно version:" . current($memcahed->getVersion()) . "<br>";
} catch (Throwable $e) {
    echo "Ошибка подключение Memcached:" . "<br>" . $e->getMessage() . "<br>";
}

//mysql
try {
    $user = getenv("MYSQL_USER");
    $pass = getenv("MYSQL_PASSWORD");
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO("mysql:host=mysql;dbname=myfirstsyte", $user, $pass, $opt);
    $stmt = $pdo->query('SHOW DATABASES;');

    while ($row = $stmt->fetch()) {
        print_r($row);
    }
} catch (\Throwable $e) {
    print_r($e->getMessage());
}

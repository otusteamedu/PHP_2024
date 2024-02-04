<?php

echo "Hello is my first docker contaner" . "<br>";

try {
    $redis = new Redis();
    $redis->connect(getenv('REDIS_CONTAINER'), getenv('REDIS_PORT'));
    echo "Redis подключение успешно ping:" . $redis->ping() . "<br>";
    $redis->close();
} catch (Throwable $e) {
    echo "Ошибка подключение к Redis:" . "<br>" . $e->getMessage() . "<br>";
}

try {
    $memcahed = new \Memcached();
    $memcahed->addServer(getenv('MEMCACHED_CONTAINER'), getenv('MEMCACHED_PORT'));
    echo "Memcached подключение успешно version:" . current($memcahed->getVersion()) . "<br>";
} catch (Throwable $e) {
    echo "Ошибка подключение Memcached:" . "<br>" . $e->getMessage() . "<br>";
}

try {
    $dsn = 'mysql:host=' . getenv('MYSQL_CONTAINER') . ';';
    $dsn .= 'port=' . getenv('MYSQL_PORT') . ';';
    $dsn .= 'dbname=' . getenv('MYSQL_DATABASE') . ';';
    $user = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');
    $db = new PDO($dsn, $user, $password);
    $tables = $db->query('SHOW TABLES');
    echo "Подключение к базе данных успешно,количество таблиц:" . $tables->rowCount() . "<br>";
} catch (PDOException $e) {
    echo "Ошибка подключение к базе данных:" . "<br>" . $e->getMessage() . "<br>";
}

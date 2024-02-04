<?php
header('Content-type: text/plain');
echo "Hello is my first docker contaner" . PHP_EOL;

try {
    $redis = new Redis();
    $redis->connect(getenv('REDIS_CONTAINER'), getenv('REDIS_PORT'));
    echo "Redis подключение успешно ping:" . $redis->ping() . PHP_EOL;
    $redis->close();
} catch (Throwable $e) {
    echo "Ошибка подключение к Redis:" . PHP_EOL . $e->getMessage() . PHP_EOL;
}


try {
    $memcahed = new \Memcached();
    $memcahed->addServer(getenv('MEMCACHED_CONTAINER'), getenv('MEMCACHED_PORT'));
    echo "Memcached подключение успешно version:" . current($memcahed->getVersion()) . PHP_EOL;
} catch (Throwable $e) {
    echo "Ошибка подключение Memcached:" . PHP_EOL . $e->getMessage() . PHP_EOL;
}


try {
    $dsn = 'mysql:host=' . getenv('MYSQL_CONTAINER') . ';';
    $dsn .= 'port=' . getenv('MYSQL_PORT') . ';';
    $dsn .= 'dbname=' . getenv('MYSQL_DATABASE') . ';';
    $user = getenv('MYSQL_USER');
    $password = getenv('MYSQL_PASSWORD');
    $db = new PDO($dsn, $user, $password);
    $tables = $db->query('SHOW TABLES');
    echo "Подключение к базе данных успешно,количество таблиц:". $tables->rowCount() . PHP_EOL;
} catch (PDOException $e) {
    echo "Ошибка подключение к базе данных:" . PHP_EOL . $e->getMessage() . PHP_EOL;
}

?>
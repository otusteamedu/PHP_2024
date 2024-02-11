<?php
connectRedis();
echo "<br>";
connectMemcached();
echo "<br>";
connectMySql();

function connectRedis() {
    $redisHost = getenv("REDIS_HOST");
    $redisPort = getenv("REDIS_PORT");

    $redis = new Redis();
    try {
        $redis->connect($redisHost, $redisPort);
        if ($redis->ping()) {
            print_r("redis connected");
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}

function connectMemcached() {
    $memcachedHost = getenv("MEMCACHED_HOST");
    $memcachedPort = getenv("MEMCACHED_PORT");

    $memcached = new Memcached();
    $memcached->addServer($memcachedHost, $memcachedPort);
    print_r($memcached->getVersion());
}

function connectMySql() {
    $mySqlHost = getenv("MYSQL_HOST");
    $mySqlUserName = getenv("MYSQL_USER");
    $mySqlPassword = getenv("MYSQL_PASSWORD");
    $mySqlDb = getenv("MYSQL_DATABASE");
    $mySqlPort = getenv("MYSQL_PORT");

    $link = mysqli_connect($mySqlHost, $mySqlUserName, $mySqlPassword, $mySqlDb, $mySqlPort);

    if ($link === false){
        print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
    }
    else {
        print("Соединение установлено успешно");
    }
}


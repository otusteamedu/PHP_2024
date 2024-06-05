<?php

checkBaseConnect();
addTwoBr();
checkRedisConnect();
addTwoBr();
checkMemcachedConnect();


function checkBaseConnect()
{
    $dbname = getenv("POSTGRES_DB");
    $dbuser = getenv("POSTGRES_USER");
    $dbpassword = getenv("POSTGRES_PASSWORD");
    $dbhost = getenv("DB_HOST");
    $dbport = getenv("DB_PORT");

    $dbconn = pg_connect("host={$dbhost} port={$dbport} dbname={$dbname} user={$dbuser} password={$dbpassword}");

    if ($dbconn) {
        echo "Connected to <b>{$dbhost}</b> successfully!";
        pg_close($dbconn);
    } else {
        echo "<b>{$dbhost}</b> connection error";
    }
}

function checkRedisConnect()
{
    $redishost = getenv("REDIS_HOST");
    $redisport = getenv("REDIS_PORT");

    try {
        $redis = new Redis();
        $redis->connect($redishost, $redisport);
        echo "Connected to <b>{$redishost}</b> successfully!";
    } catch (RedisException $ex) {
        echo $ex;
        return false;
    }
}

function checkMemcachedConnect()
{

    $memcachedhost = getenv("MEMCACHED_HOST");
    $memcachedport = getenv("MEMCACHED_PORT");

    $memcached = new Memcached();
    $memcached->addServer($memcachedhost, $memcachedport);
    $stats = $memcached->getStats();
    if (!empty($stats)) {
        echo "Connected to <b>{$memcachedhost}</b> successfully!";
    } else {
        echo "<b>{$memcachedhost}</b> connection error";
    }
}

function addTwoBr()
{
    echo "<br><br>";
}

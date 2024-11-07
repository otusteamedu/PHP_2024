<?php

$env = parse_ini_file('.env');

redis($env);
mysql($env);
memcached($env);


function redis($env)
{
    $redis = new Redis();
    $redis->connect($env['REDIS_HOST'], $env['REDIS_PORT']);

    try {
        $redis->ping();
        echo "Redis connected successfully" . PHP_EOL;
    } catch (Exception $e) {
        die("Connection failed: " . $e->getMessage());
    }
}


function mysql($env)
{
    $conn = new mysqli($env['DB_HOST'], $env['DB_USERNAME'], $env['DB_PASSWORD'], $env['DB_DATABASE']);

    if ($conn->connect_error) {
        die("Mysql connection failed: " . $conn->connect_error);
    } else {
        echo "Mysql connected successfully" . PHP_EOL;
    }
}

function memcached($env)
{
    $mc = new Memcached();
    $mc->addServer($env['MEMCACHED_HOST'], $env['MEMCACHED_PORT']);
    $statuses = $mc->getStats();
    if ($statuses[$env['MEMCACHED_HOST'] . ':' . $env['MEMCACHED_PORT']]['uptime'] < 1) {
        die("Memcached connection failed");
    } else {
        echo "Memcached connected successfully" . PHP_EOL;
    }
}

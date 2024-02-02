<?php

$dsn = "pgsql:host=hw1-postgres;port=5432;dbname=hw1-db;";
new PDO($dsn, 'hw1-user', 'hw1-password', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
echo 'db is working <br>';

$memcache = new Memcache();
$connected = $memcache->connect('hw1-memcache', 11211);
$memcache->set('status', 'memcache is working');
echo $memcache->get('status') . '<br>';

$redis = new Redis();
$redis->connect('hw1-redis');
$redis->set('status', 'redis is working');
echo $redis->get('status');

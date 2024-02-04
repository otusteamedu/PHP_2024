<?php

echo "<h1>Application " . getenv('APP_NAME') . " - " . date('Y') . "</h1>";
echo "<img src='img.jpg'>";

$redis = new Redis;
if ($redis->connect(getenv('REDIS_HOST'))) {
    echo "<p>Redis is connected!</p>";
} else {
    echo "<p>Redis is not connected!</p>";
}


$m = new Memcached();
if ($m->addServer(getenv('MEMCACHED_HOST'), getenv('MEMCACHED_PORT'))) {
    echo "<p>Memcached is connected!</p>";
} else {
    echo "<p>Memcached is not connected!</p>";
}

$dbconn = pg_connect(
    "host=" . getenv('DB_HOST') . " " .
    "dbname=" . getenv('DB_NAME') . " " .
    "user=" . getenv('DB_USER') . " " .
    "password=" . getenv('DB_PASSWORD')
);
if (!$dbconn) {
    echo "<p>DB is not connected!</p>";
} else {
    pg_close($dbconn);
    echo "<p>DB is connected!</p>";
}


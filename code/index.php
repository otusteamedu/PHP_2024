<?php

echo "<pre>";

$redis = new Redis();
$redis->connect('redis', 6379);
$redis->auth(getenv("REDIS_PASSWORD"));

if ($redis->ping()) {
    print_r('Redis is alive!!!!!!');
    echo "<hr />";
}

$mc = new Memcached();
$mc->addServer("memcached", 11211);
$mc->set("foo", "Hello!");
$mc->set("bar", "Memcached...");
$data = [
    $mc->get("foo"),
    $mc->get("bar")
];

print_r($data);
echo "<hr />";

try {
    $user = getenv("DB_USER");
    $pass = getenv("DB_PASSWORD");
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    $pdo = new PDO("mysql:host=mysql;dbname=mysite", $user, $pass, $opt);
    $stmt = $pdo->query('SHOW DATABASES;');

    while ($row = $stmt->fetch()) {
        print_r($row);
    }
} catch (\Throwable $e) {
    print_r($e->getMessage());
}

echo "<hr />";

echo "</pre>";

phpinfo();

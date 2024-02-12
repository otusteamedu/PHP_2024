<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$newLine = '<br>';

if (class_exists('Redis')) {
    $redis = new \Redis();
    try {
        $redis->connect('redis', getenv('REDIS_PORT'));

        echo 'Redis connected:' . $redis->ping() . $newLine;
        $redis->close();
    } catch (\Exception $e) {
        echo "Redis error: {$e->getMessage()} $newLine";
    }
}

try {
    $memcached = new \Memcached();
    $memcachedServerConnection = $memcached->addServer('memcached', getenv('MEMCACHED_PORT'));

    if ($memcachedServerConnection === true) {
        echo 'Memcached is connected' . $newLine;
    } else {
        echo 'Memcached is not connected' . $newLine;
    }
} catch (Exception $e) {
    echo "Memcached error: {$e->getMessage()} $newLine";
}

$host = getenv('MYSQL_HOST');
$db = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_ROOT_PASSWORD');
$charset = getenv('MYSQL_CHARSET');

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    $opt = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $opt);
    echo 'PDO is connected' . $newLine;
} catch (PDOException $e) {
    echo "PDO error: {$e->getMessage()} $newLine";
}
?>
</body>
</html>


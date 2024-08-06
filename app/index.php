<?php

$memcache = new Memcache();
$memcache->addServer('memcached');
$status = $memcache->getStats();
if($status!==false) {
    echo 'Memcahed version: '.$memcache->getVersion()."\n";
} else{
    echo "Memcahed error\n";
}


$redis = new Redis();
try{
    $redis->connect("redis");
    if($redis->ping()) {
        $info = $redis->info();
        echo "Redis version: ".$info['redis_version']." \n";

    } else {
        echo "Redis connection error\n";
    }

} catch (Exception $err) {
    echo "Error: ".$err->getMessage();
}

$host = getenv('MYSQL_HOST');
$database = getenv('MYSQL_DATABASE');
$username = getenv('MYSQL_USER');
$password = getenv('MYSQL_PASSWORD');

$dsn = "mysql:host=$host;dbname=$database;charset=utf8mb4";
try {

    $pdo = new PDO($dsn, $username, $password);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Подключение к MySQL успешно.";
} catch (PDOException $e) {

    die("Ошибка подключения: " . $e->getMessage());
}
?>
<?php

echo '<pre>';

$redis = new Redis();

try {
	$redis->connect('redis', '6379');
	echo 'Redis is connected ' . $redis->ping() . PHP_EOL;
	$redis->close();
} catch (\Exception $e) {
	echo "Redis error: " . $e->getMessage() . PHP_EOL;
}

try {
	$memcached = new \Memcached();
	$memcachedServerConnection = $memcached->addServer('memchached', '11211');

	if ($memcachedServerConnection === true) {
		echo 'Memcached is connected' . PHP_EOL;
	} else {
		echo 'Memcached is not connected' . PHP_EOL;
	}
} catch (Exception $e) {
	echo 'Memcached error: ' . $e->getMessage() . PHP_EOL;
}

$host = getenv('MYSQL_HOST');
$db = getenv('MYSQL_DATABASE');
$user = getenv('MYSQL_USER');
$pass = getenv('MYSQL_PASSWORD');
$charset = getenv('MYSQL_CHARSET');

$dsn = 'mysql:host=' . $host . ';dbname=' . $db;
$dbh = new PDO($dsn, $user, $pass);
echo 'Mysql is connected' . PHP_EOL;
$sth = $dbh->query('SELECT * FROM hw1');
$result = $sth->fetchAll(PDO::FETCH_ASSOC);
print_r($result);
echo '</pre>';

<?php

require __DIR__ . '/vendor/autoload.php';

use Predis\Client;

$redisHost = getenv('REDIS_HOST');
$redisPort = getenv('REDIS_PORT');

$redisClient = new Client(['host' => $redisHost, 'port' => $redisPort]);

try
{
	$redisClient->set('connect', 'Redis connected');
	$redisValue = $redisClient->get('connect');
	echo "<div style=\"color:red\">$redisValue</div></br>";
}
catch (Exception $e)
{
	echo 'Error connect Redis: ' . $e->getMessage() . '</br>';
}

$memcachedHost = getenv('MEMCACHED_HOST');
$memcachedPort = getenv('MEMCACHED_PORT');
$memcached = new Memcached();
$memcached->addServer($memcachedHost, $memcachedPort);
$memcached->set('connect', 'Memcached connected');
$memcachedValue = $memcached->get('connect');

if ($memcachedValue)
{
	echo "<div style=\"color:blue\">$memcachedValue</div></br>";
}
else
{
	echo 'Error connect Memcached' . '</br>';
}

$postgresHost = getenv('POSTGRES_HOST');
$postgresDBName = getenv('POSTGRES_DB_NAME');
$postgresUserName = getenv('POSTGRES_USER_NAME');
$postgresPassword = getenv('POSTGRES_PASSWORD');
$postgresPort = getenv('POSTGRES_PORT');
$dsn = "pgsql:host=$postgresHost;port=$postgresPort;dbname=$postgresDBName;";

try
{
	$pdo = new PDO("pgsql:host=$postgresHost;port=$postgresPort;dbname=$postgresDBName;", $postgresUserName, $postgresPassword);
	echo "<div style=\"color:orange\">Postgres connected</div></br>";
}
catch (\PDOException $e)
{
	echo "Could not connect to the database $postgresDBName:" . $e->getMessage();
}
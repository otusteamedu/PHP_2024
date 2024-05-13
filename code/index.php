<?php

$redis = new Redis();
$redis->connect('redis', 6379);
$redis->set('test_key', 'Hello, Redis!');
$value = $redis->get('test_key');

echo $value . '<br>';

$memcached = new Memcached();
$memcached->addServer('memcached', 11211);

$memcached->set('test_key', 'Hello, Memcached!', 60);
$value = $memcached->get('test_key');

echo $value . '<br>';


$servername = "mysql";
$username = "user";
$password = "password";
$dbname = "mydatabase";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Database Connected successfully <br>";

$conn->close();

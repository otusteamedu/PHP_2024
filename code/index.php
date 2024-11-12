<?php

require_once __DIR__ . '/vendor/autoload.php';

// Access environment variables
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');

if (connectToDB($host, $dbname, $username, $password)) {
    echo " Connected successfully to the database! ";
} else {
    echo " Failed to connect to the database. ";
}

// Example usage of redis
$redis = connectToRedis();
$redis->set('foo', 'bar');
echo ' Redis: ' . $redis->get('foo') . ' ';  // Outputs: bar

// Example usage of memcached
$memcached = connectToMemcached();
$memcached->set('key', 'value');
echo ' Memcached: ' . $memcached->get('key');  // Outputs: value

function connectToDB($host, $dbname, $username, $password) {
    try {
        // Create a new PDO instance and set the connection parameters
        $dsn = "mysql:host={$host};dbname={$dbname}";
        $connection = new PDO($dsn, $username, $password);

        // Set the PDO error mode to exception
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return true;
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
        return false;
    }
}

function connectToRedis() {
    $host = 'redis';  // Hostname of the Redis server (Docker service name or IP address)
    $port = 6379;     // Default Redis port

    try {
        $redis = new Redis();
        $redis->connect($host, $port);  // Connect to Redis server
        echo "Connected to Redis successfully!";
        return $redis;
    } catch (Exception $e) {
        echo "Redis connection failed: " . $e->getMessage();
    }
}

function connectToMemcached() {
    $host = 'memcached';  // Hostname of the Memcached server (Docker service name or IP address)
    $port = 11211;        // Default Memcached port

    try {
        $memcached = new Memcached();
        $memcached->addServer($host, $port);  // Connect to the Memcached server
        echo "Connected to Memcached successfully!";
        return $memcached;
    } catch (Exception $e) {
        echo "Memcached connection failed: " . $e->getMessage();
    }
}

phpinfo();
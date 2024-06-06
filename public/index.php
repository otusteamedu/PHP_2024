<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

checkMysql();
checkRedis();
checkMemcached();

function checkMysql(): void
{
    // Database connection parameters
    $host = 'mysql';   // MySQL server hostname within the same Docker network
    $user = 'root';    // MySQL username
    $pass = $_SERVER['MYSQL_ROOT_PASSWORD'];   // MySQL password
    $db = 'mysql';// MySQL database name

    // Create a new MySQLi object to establish a database connection
    $conn = new mysqli($host, $user, $pass, $db);

    // Check if the connection was successful
    if ($conn->connect_error) {
        // Display an error message and terminate the script if the connection fails
        die("Connection failed: " . $conn->connect_error . "<br>");
    }

    // If the connection is successful, print a success message
    echo "PHP Connected to MySQL successfully" . "<br>";

    // Close the database connection
    $conn->close();
}

function checkRedis(): void
{
    // Redis configuration
    $vm = [
        'host' => 'redis',
        'port' => 6379,
        'timeout' => 0.8 // (expressed in seconds) used to connect to a Redis server after which an exception is thrown.
    ];

    $redis = new Predis\Client($vm);

    try {
        $redis->ping();
        echo "Redis: OK" . "<br>";
    } catch (Exception $e) {
        echo "Redis error: " . $e->getMessage() . "<br>";
    }
}

function checkMemcached(): void
{
    $host = 'memcached';
    $port = 11211;

    $memcached = new Memcached();
    $memcached->addServer($host, $port);

    $statuses = $memcached->getStats();

    echo "Memcached: " . (isset($statuses[$host . ":" . $port]) ? 'connected' : 'disconnected') . "<br>";
}

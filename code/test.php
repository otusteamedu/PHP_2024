<?php

echo "Some text to check if the page works well.<br><br>";

$env = getenv();

if (!isset($env['MYSQL_DATABASE'], $env['MYSQL_HOST'], $env['MYSQL_USER'], $env['MYSQL_PASSWORD'])) {
    echo "Database env variables have not set for access! Exit without try to connect!<br>";
    return;
}

try {
    $pdo = new \PDO("mysql:host={$env['MYSQL_HOST']};dbname={$env['MYSQL_DATABASE']}", $env['MYSQL_USER'], $env['MYSQL_PASSWORD']);
    echo "Database has been connected!<br><br>";
} catch (PDOException $exception) {
    echo "Database connection error:<br><b>{$exception->getMessage()}</b><br><br>";
}


$memcached = new Memcached();
$memcached->addServer('memcached', 11211);
echo 'Testing memcached extention...<br><pre>';
print_r($memcached->getServerList());
echo '</pre>';

if ($memcached->getStats() === false) {
    echo 'Returned false!';
} else {
    echo '<pre>';
    print_r($memcached->getStats());
    print_r($memcached->getAllKeys());
    echo '</pre><br>';
}

$response = $memcached->get("test");
if ($response) {
    echo "The test key already exists. Its value is: {$response}<br><br>";
} else {
    echo "Adding test key ...<br><br>";
    $memcached->set("test", "The test key was memcached!") or die("The test key couldn't be created!!!");
}

echo "<br><br>Testing redis extention ... <br><br>";
$redis = new Redis();
try {
    $redis->connect('redis', 6379);

    echo "Server is running: " . $redis->ping();

    $redis->set('test', 'Redis. Saved value!');
    $glueStatus = $redis->get('test');
    if ($glueStatus) {
        echo '<pre>';
        print_r($glueStatus);
        echo "<br>";
        print_r($redis->keys("*"));
        echo '</pre>';
    } else {
        echo 'Returned false!';
    }
} catch (RedisException $e) {
    echo "Error: " . $e->getMessage();
}

<?php

echo '<h1>Hello world! ' . date('Y-m-d h:i:s') . '</h1>';

ini_set('display_errors', 'on');


// check mysql
// @todo this should be exposed to env from .env file
$servername = "percona";
$username = "root";
$password = "example";
$dbname = "hw1";

try {
    $dbh = new pdo(
        'mysql:host=percona:3306;dbname=' . $dbname,
        $username,
        $password,
        array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
    );

    echo '<h1>Database connected</h1>';
} catch (PDOException $ex) {
    echo $ex->getMessage().PHP_EOL;
//    die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
}

// check memcache

if (class_exists('Memcache')) {
    $server = 'memcached';
    if (!empty($_REQUEST['server'])) {
        $server = $_REQUEST['server'];
    }
    $memcache = new Memcache;
    $isMemcacheAvailable = @$memcache->connect($server);

    if ($isMemcacheAvailable) {
        $aData = $memcache->get('data');
        echo '<pre>';
        if ($aData) {
            echo '<h2>Data from Cache:</h2>';
            print_r($aData);
        } else {
            $aData = array(
                'me' => 'you',
                'us' => 'them',
            );
            echo '<h2>Fresh Data:</h2>';
            print_r($aData);
            $memcache->set('data', $aData, 0, 300);
        }
        $aData = $memcache->get('data');
        if ($aData) {
            echo '<h3>Memcache seem to be working fine!</h3>';
        } else {
            echo '<h3>Memcache DOES NOT seem to be working!</h3>';
        }
        echo '</pre>';
    }
}
if (!$isMemcacheAvailable) {
    echo 'Memcache not available';
}


// check redis

$redis = new Redis();

try {
    $redis->connect('redis', 6379);

    echo $redis->ping();
} catch (Exception $exception) {
    throw $exception;

    echo $exception->getMessage() . PHP_EOL;
}

phpinfo();
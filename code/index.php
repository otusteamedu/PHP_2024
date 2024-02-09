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
        $redis->connect('redis', 6379);

        echo 'Redis connected:' . $redis->ping() . $newLine;
        $redis->close();
    } catch (\Exception $e) {
        echo "Redis error: {$e->getMessage()} $newLine";
    }


}

try {
    $memcached = new \Memcached();
    $memcachedServerConnection = $memcached->addServer('memcached', 11211);

    if ($memcachedServerConnection === true) {
        echo 'Memcached is connected' . $newLine;
    } else {
        echo 'Memcached is not connected' . $newLine;
    }
} catch (Exception $e) {
    echo "Error: {$e->getMessage()} $newLine";
}


echo '<pre>';
print_r(get_loaded_extensions());
echo '</pre>';
phpinfo();
?>
</body>
</html>


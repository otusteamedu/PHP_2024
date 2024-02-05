<?php
echo "Hello, Otus!";

echo '<pre>';
print_r(get_loaded_extensions());
echo '</pre>';

if (class_exists('Redis')) {
    $redis = new \Redis();
    try {
        $redis->connect('redis', 6379);
    } catch (\Exception $e) {
        var_dump($e->getMessage());
        die;
    }

    echo "Connection to server successfully <br>";

    echo "Server is running: " . $redis->ping() . "<br>";
}
phpinfo();

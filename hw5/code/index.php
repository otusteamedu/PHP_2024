<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
             <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
                         <meta http-equiv="X-UA-Compatible" content="ie=edge">
             <title>Document</title>
</head>
<body>
<?php
echo "It's work!!!!<br>" . date("Y-m-d H:i:s") . "<br><br>\n";
echo "<pre>\n";
echo "--------------\n";
echo "Адрес nginx: {$_SERVER['SERVER_ADDR']}\n";  // если меняется, значит переключаемся между nginx-ами
echo "PHP host: {$_SERVER['HOSTNAME']}\n"; // если меняется, значит переключаемся между экземплярами PHP-fpm
echo "--------------\n";
echo "</pre>\n";
?>

<form method="post" action="<?=$_SERVER['SCRIPT_NAME']?>" name="redis">
    <b>Redis</b><br>
    key: <input type="text" name="redis_key"><br>
    value: <input type="text" name="redis_value"><br>
    <button type="submit">set redis</button><br>
</form>
<hr>
<form method="post" action="<?=$_SERVER['SCRIPT_NAME']?>" name="mem">
    <b>Memcached</b><br>
    key: <input type="text" name="mem_key"><br>
    value: <input type="text" name="mem_value"><br>
    <button type="submit">set memcached</button><br>
</form>
<hr>
<form method="post" action="<?=$_SERVER['SCRIPT_NAME']?>">
    <b>Read</b><br>
    key: <input type="text" name="read_key"><br>
    <button type="submit">read</button><br>
</form>
<hr>

<?php
if (!empty($_REQUEST['redis_key'])) {
    try {
        $redis = new Redis();
        $redis->connect('hw5_redis');
        $redis->set($_REQUEST['redis_key'], $_REQUEST['redis_value'], ['EX' => 60 * 5]);
    } catch (RedisException $ex) {
        echo "RedisException: \n";
        echo "<pre>\n";
        print_r($ex);
        echo "</pre>\n";
    }
} elseif (!empty($_REQUEST['mem_key'])) {
    $memcached = new Memcached();
    $memcached->addServer('hw5_memcached', 11211);
    $memcached->set($_REQUEST['mem_key'], $_REQUEST['mem_value'], 60 * 5);
} elseif (!empty($_REQUEST['read_key'])) {
    try {
        $redis = new Redis();
        $redis->connect('hw5_redis');
        $redisResult = $redis->get($_REQUEST['read_key']);
        if ($redisResult === false) {
            $redisResult = '--//--';
        }
    } catch (RedisException $ex) {
        echo "RedisException: \n";
        echo "<pre>\n";
        print_r($ex);
        echo "</pre>\n";
        $redisResult = '--//--';
    }

    $memcached = new Memcached();
    $memcached->addServer('hw5_memcached', 11211);
    $memcachedResult = $memcached->get($_REQUEST['read_key']);
    if ($memcachedResult === false) {
        $memcachedResult = '--//--';
    }


    echo "in redis: $redisResult <br>\n";
    echo "in memcached: $memcachedResult <br>\n";
}


?>


</body>
</html>


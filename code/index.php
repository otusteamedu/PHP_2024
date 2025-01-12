<?php

echo "123 456 Привет, Otus!<br>" . date("Y-m-d H:i:s") . "<br><br>";

echo "Новая строка";

//$redis = new Redis();
//
//$redis->connect(
//    'redis',
//    6379
//);
//
//$redis->auth($_ENV['REDIS_PASSWORD']);
//
//echo "11";

$memcached = new Memcached();

$memcached->addServer('memcache', 11211);

echo '<pre>';
print_r($memcached->getServerList());
echo '</pre>';

if ($memcached->getStats() === false) {
    echo 'returned false';
} else {
    echo '<pre>';
    print_r($memcached->getStats());
    echo '</pre>';
}


// $port = 6379;
// $address = "";
// $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
// $res = socket_connect($socket, $address, $port);
//     if($res){
//         echo 'Redis connected';
//         socket_write ( $socket , 'auth password'.PHP_EOL );
//         echo socket_read($socket, 100); //если все ОК, получаем ответ: +OK\r\n
//     }
socket_close($socket);


phpinfo();
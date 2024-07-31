<?php

$memcache = new Memcache();
$memcache->addServer('memcached');
$status = $memcache->getStats();
if($status!==false) {
    echo 'Memcahed version: '.$memcache->getVersion()."\n";
} else{
    echo "Memcahed error\n";
}


$redis = new Redis();
try{
    $redis->connect("redis");
    if($redis->ping()) {
        $info = $redis->info();
        echo "Redis version: ".$info['redis_version']." \n";

    } else {
        echo "Redis connection error\n";
    }

} catch (Exception $err) {
    echo "Error: ".$err->getMessage();
}


?>
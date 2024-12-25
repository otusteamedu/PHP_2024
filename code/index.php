<?php
$memcached = new Memcached;

$memcached->addServer('memcached', '11211');

echo '<pre>'; print_r($memcached->getServerList()); echo '</pre>';

if($memcached->getStats()) {
    echo '<pre>'; print_r($memcached->getStats()); echo '</pre>';
}

phpinfo();

?>

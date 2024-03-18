<?php

require_once 'includes/redis-check.php';
require_once 'includes/memcached-check.php';
require_once 'includes/mysql-check.php';

?>

<p>Redis: <?= isRedisConnected() ? 'Connected' : 'Error' ?></p>
<p>Memcached: <?= isMemcachedConnected() ? 'Connected' : 'Error' ?></p>
<p>MySQL: <?= isMySQLConnected() ? 'Connected' : 'Error' ?></p>

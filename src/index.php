<?php

require_once 'includes/redis-check.php';
require_once 'includes/memcached-check.php';

?>

<p>Redis: <?= isRedisConnected() ? 'Connected' : 'Error' ?></p>
<p>Memcached: <?= isMemcachedConnected() ? 'Connected' : 'Error' ?></p>

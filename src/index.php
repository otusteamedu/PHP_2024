<?php

require_once "includes/redis-check.php";

?>

<p>Redis: <?= isRedisConnected() ? 'Connected' : 'Error' ?></p>

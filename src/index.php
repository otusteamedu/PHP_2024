<?php

declare(strict_types=1);

?>
    <p>Redis check: <?= isRedisConnected() ? 'Success' : 'Error' ?></p>
    <p>Memcached check: <?= isMemcachedConnected() ? 'Success' : 'Error' ?></p>
    <p>MySQL check: <?= isMySQLConnected() ? 'Success' : 'Error' ?></p>
<?php

/**
 * @return bool
 */
function isMemcachedConnected(): bool
{
    $memcached = new Memcached();

    try {
        $memcached->addServer(getenv('MEMCACHED_HOST'), (int)getenv('MEMCACHED_PORT'));
    } catch (Throwable $e) {
        echo $e->getMessage();
        return false;
    }

    $memcached->set('key', 1);

    return $memcached->getResultCode() === Memcached::RES_SUCCESS && !empty($memcached->get('key'));
}

/**
 * @return bool
 */
function isMySQLConnected(): bool
{
    $dsn = sprintf(
        "mysql:host=%s;port=%s;dbname=%s",
        getenv('MYSQL_HOST'),
        getenv('MYSQL_PORT'),
        getenv('MYSQL_DATABASE')
    );

    try {
        new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));
    } catch (Throwable $e) {
        echo $e->getMessage();
        return false;
    }

    return true;
}

/**
 * @return bool
 */
function isRedisConnected(): bool
{
    $redis = new Redis();

    try {
        $redis->connect(getenv('REDIS_HOST'), (int)getenv('REDIS_PORT'));

        return $redis->ping();
    } catch (Throwable $e) {
        echo $e->getMessage();
        return false;
    }
}

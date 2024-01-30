<?php

phpinfo();

try {
    $PDO = new PDO(
        getenv('MYSQL_DNS'),
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD')
    );
    $query = $PDO->query('SHOW DATABASES');
    $fetch = $query->fetchAll();
    echo '
    <p>
        <span>MYSQL Success</span>
        <pre>' . print_r($fetch, true) . '</pre>
    </p>
    ';
} catch (\Throwable $exception) {
    echo '
    <p>
        <span>MYSQL Error</span>
        <pre>' . $exception->getMessage() . '</pre>
    </p>
    ';
}

$redis = new Redis();

try {
    $redis->connect(
        getenv('REDIS_CONTAINER_NAME'),
        getenv('REDIS_PORT')
    );

    if ($redis->ping()) {
        $redis->set('int', 100);
        echo '
        <p>
            <span>Redis Success</span>
            <pre>Get value -> ' . $redis->get('int') . '</pre>
        </p>
        ';
    } else {
        echo '
        <p>
            <span>Redis Error</span>
            <pre>No Ping</pre>
        </p>
        ';
    }
} catch (\Throwable $exception) {
    echo '
    <p>
        <span>Redis Error</span>
        <pre>' . $exception->getMessage() . '</pre>
    </p>
    ';
}

$memcached = new Memcached();
try {
    $memcached->addServer(
        getenv('MEMCACHED_CONTAINER_NAME'),
        getenv('MEMCACHED_PORT')
    );
    $memcached->set('int', 1000);

    echo '
    <p>
        <span>Memcached Success</span>
        <pre>Get value -> '.$memcached->get('int').'</pre>
    </p>
    ';
} catch (\Throwable $exception) {
    echo '
    <p>
        <span>Memcached Error</span>
        <pre>'.$exception->getMessage().'</pre>
    </p>
    ';
}

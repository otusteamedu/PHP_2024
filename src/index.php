<?php

echo (new Memcached())->addServer('memcached', 11211) ? 'Memcached is running <br />' : 'Memcached is not running <br />';

echo (new Redis())->connect('redis') ? 'Redis is running <br />' : 'Redis is not running <br />';

try {
    $pdo = new PDO('pgsql:host=db;port=5432;dbname=app_db', 'app_db_user', 'password');
    echo 'Postgres is running';
} catch (Exception $e) {
    echo 'Postgres is not running';
}

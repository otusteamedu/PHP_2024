<?php

namespace Core;

use PDO;
use Memcached;

class Common
{
    public static array $CONFIG = [];
    private static \Predis\Client $Client;
    private static PDO $Db;
    private static Memcached $Memcached;

    public function __construct($CONFIG)
    {
        self::$CONFIG = $CONFIG;

        $dsn = 'mysql:host=' . $CONFIG['db_host'] . ';dbname=' . $CONFIG['db_name'];
        $user = $CONFIG['db_user'];
        $password = $CONFIG['db_pass'];
        self::$Db = new PDO($dsn, $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
        self::$Db->query('SET SESSION group_concat_max_len = ~0;');

        self::$Memcached = new Memcached();
        self::$Memcached->addServer('memcached', 11211);

        self::$Client = new \Predis\Client(['host' => $CONFIG['redis_host'], 'port' => $CONFIG['redis_port'],]);

        return $this;
    }

    public static function setRedis($key, $value)
    {
        self::$Client->set($key, $value);
    }

    public static function getRedis($key)
    {
        return self::$Client->get($key);
    }
    public static function setMemcashed($key, $value)
    {
        self::$Memcached->set($key, $value);
    }

    public static function getMemcashed($key)
    {
        return self::$Memcached->get($key);
    }
}
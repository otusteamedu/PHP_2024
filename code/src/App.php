<?php

namespace AlexAgapitov\OtusComposerProject;

use PDO;

class App {

    private static PDO $Db;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASS'];
        self::$Db = new PDO($dsn, $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
        self::$Db->query('SET SESSION group_concat_max_len = ~0;');
    }
}
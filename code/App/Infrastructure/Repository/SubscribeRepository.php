<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Subscribe;
use App\Domain\Repository\SubscribeRepositoryInterface;
use App\Domain\ValueObject\Category;
use PDO;

class SubscribeRepository implements SubscribeRepositoryInterface
{
    private static PDO $Db;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $_ENV['db_host'] . ';dbname=' . $_ENV['db_name'];
        $user = $_ENV['db_user'];
        $password = $_ENV['db_pass'];
        self::$Db = new PDO($dsn, $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
        self::$Db->query('SET SESSION group_concat_max_len = ~0;');
    }

    public function save(Subscribe $subscribe): void
    {
        $sql_q = "INSERT INTO `subscriptions` SET 
                   `user_id` = ".$subscribe->getUserId()->getValue().",
                   `category` = ".self::$Db->quote($subscribe->getCategory()->getValue());

        if (false === self::$Db->query($sql_q)) {
            throw new \Exception('Error save subscription');
        }

        $id = self::$Db->lastInsertId();

        $reflectionProperty = new \ReflectionProperty(Subscribe::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($subscribe, $id);
    }

    public function getByCategory(Category $category): array
    {
        $sql_q = "SELECT user_id FROM subscriptions WHERE `category` = ".self::$Db->quote($category->getValue());
        return self::$Db->query($sql_q)->fetchAll(PDO::FETCH_COLUMN) ?? [];
    }
}
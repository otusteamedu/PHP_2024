<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Factory\CommonNewsFactory;
use PDO;

class NewsRepository implements NewsRepositoryInterface
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

    public function findAll(): iterable
    {
        $news = [];
        $sql_q = "SELECT * FROM `news`";

        $rows = self::$Db->query($sql_q)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($rows ?? [] AS $row) {
            $news[] = $this->prepareNews($row);
        }

        return $news;
    }

    /**
     * @throws \ReflectionException
     */
    public function findById(int $id): ?News
    {
        $news = null;
        $sql_q = "SELECT * FROM `news` WHERE `id` = $id";

        $row = self::$Db->query($sql_q)->fetch(PDO::FETCH_ASSOC);

        if (!empty($row)) {
            $news = $this->prepareNews($row);
        } else {
            throw new \Exception('News not found');
        }

        return $news;
    }

    /**
     * @throws \Exception
     */
    public function save(News $news): void
    {
        $sql_q = "INSERT INTO `news` SET 
                   `name` = ".self::$Db->quote($news->getName()->getValue()).",
                   `author` = ".self::$Db->quote($news->getAuthor()->getValue()).",
                   `category` = ".self::$Db->quote($news->getCategory()->getValue()).",
                   `date_created` = NOW(),
                   `text` = ".self::$Db->quote(htmlspecialchars($news->getText()->getValue()));

        if (false === self::$Db->query($sql_q)) {
            throw new \Exception('Error save news');
        }

        $id = self::$Db->lastInsertId();

        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $id);
    }

    public function delete(News $news): void
    {
        // TODO: Implement delete() method.
    }

    private function prepareNews(array $row)
    {
        $reflectionClass = new \ReflectionClass(News::class);
        $news = $reflectionClass->newInstanceWithoutConstructor();
        foreach ($reflectionClass->getProperties() AS $property) {
            $property_name = $property->getName();
            if (isset($row[$property_name])) {
                $reflectionProperty = $reflectionClass->getProperty($property_name);
                $type = $reflectionProperty->getType()->getName();
                if(!$property->getType()->isBuiltin()) //types names are strings
                    $value = new $type($row[$property_name]);
                else
                    $value = $row[$property_name];
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($news, $value);
            }
        }
        return $news;
    }
}
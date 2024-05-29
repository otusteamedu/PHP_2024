<?php
declare(strict_types=1);
namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use PgSql\Connection;

class PostgreNewsRepository implements NewsRepositoryInterface
{
    private ?Connection $init;


    public function __construct(
        string $host,
        string $dbname,
        string $user,
        string $password
    )
    {
        $this->init = pg_connect("host=".$host." dbname=".$dbname." user=".$user." password=".$password);
    }


    public function save(News $news): void
    {
        $query = pg_query($this->init,
            "INSERT INTO news (url, title, date) 
                VALUES (
                        '".$news->getUrl()."',
                         '".$news->getTitle()."',
                          CURRENT_DATE
                ) RETURNING id;");

        $row = pg_fetch_row($query);
        $id = (int)$row[0];
        $news->setId($id);
    }

    public function findById(int $id): ?News
    {
        // TODO: Implement findById() method.
    }

    public function getAllNews()
    {
        // TODO: Implement getAllNews() method.
    }

    public function getLastFiveNews()
    {
        // TODO: Implement getLastFiveNews() method.
    }


}
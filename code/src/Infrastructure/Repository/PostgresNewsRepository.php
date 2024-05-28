<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;

class PostgresNewsRepository implements NewsRepositoryInterface
{
    private $init;


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
            "INSERT INTO news (url, title, date) VALUES 
                                        ('".$news->getUrl()."')");
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
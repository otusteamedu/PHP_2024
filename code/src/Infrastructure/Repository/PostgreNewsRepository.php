<?php
declare(strict_types=1);
namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use PgSql\Connection;

class PostgreNewsRepository implements NewsRepositoryInterface
{
    private ?Connection $init;
    private string $host;
    private string $dbname;
    private string $user;
    private string $password;


    public function __construct()
    {
        $this->host = getenv("POSTGRES_HOST");
        $this->dbname = getenv("POSTGRES_DATABASE");
        $this->user = getenv("POSTGRES_USER");
        $this->password = getenv("POSTGRES_PASSWORD");
        $this->init = pg_connect("host=".$this->host." dbname=".$this->dbname." user=".$this->user." password=".$this->password);
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

    public function getAllNews(): false|array
    {
        $query = pg_query($this->init,
            "SELECT * FROM news;");

        return pg_fetch_all($query);
    }

    public function getLastFiveNews(): array
    {
        $query = pg_query($this->init,
            "SELECT * FROM news ORDER BY id DESC LIMIT 5;");

        return pg_fetch_all($query);
    }


}
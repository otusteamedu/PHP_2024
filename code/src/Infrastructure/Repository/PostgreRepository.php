<?php
declare(strict_types=1);
namespace App\Infrastructure\Repository;

use App\Domain\Entity\Product;
use App\Domain\Repository\RepositoryInterface;
use PgSql\Connection;

class PostgreRepository implements RepositoryInterface
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

    /**
     * @throws \Exception
     */
    public function save(Product $product): int
    {
        try {
            $query = pg_query($this->init,
                "INSERT INTO products (type, recipe, status) 
                VALUES (
                        '".$product->getType()."',
                         '".$product->getRecipe()."',
                         '".$product->getStatus()."'
                ) RETURNING id;");
            $id = pg_fetch_row($query);
            $product->setId((int)$id[0]);
            return $product->getId();
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }


    /**
     * @throws \Exception
     */
    public function setStatus(int $status, int $id): void
    {
        try {
            pg_query($this->init,
                "UPDATE products SET status=$status 
                WHERE id=$id;");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function getStatus(int $id): int
    {
        try {
            $query = pg_query($this->init,
                "SELECT status FROM products WHERE id=$id;");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
        $status = pg_fetch_row($query);
        return $status[0];
    }

    /**
     * @throws \Exception
     */


    /**
     * @throws \Exception
     */
    public function delete(int $id): void
    {
        try {
            pg_query($this->init,
                "DELETE FROM products WHERE id=$id;");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function getProduct(int $id): Product
    {
        // TODO: Implement getProduct() method.
    }
}
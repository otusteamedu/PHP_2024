<?php
declare(strict_types=1);
namespace App\Infrastructure\Repository;

use App\Domain\Entity\Product;
use App\Domain\Repository\RepositoryInterface;
use PgSql\Connection;

class PostgreRepository implements RepositoryInterface
{
    private ?Connection $connection;


    public function __construct(
        readonly InitDb $init
    )
    {
        $this->connection = pg_connect("host=".$init->host." dbname=".$init->db." user=".$init->user." password=".$init->password);
    }

    /**
     * @throws \Exception
     */
    public function save(Product $product): int
    {
        try {
            $query = pg_query($this->connection,
                "INSERT INTO products (type, recipe, comment, status) 
                VALUES (
                        '".$product->getType()."',
                         '".$product->getRecipe()."',
                         '".$product->getComment()."',
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
            pg_query($this->connection,
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
            $query = pg_query($this->connection,
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
            pg_query($this->connection,
                "DELETE FROM products WHERE id=$id;");
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    public function getProduct(int $id): Product
    {
        try {
            $query = pg_query($this->connection,
                "SELECT FROM products WHERE id=$id;");
            $product = pg_fetch_all($query);
            $product->setId((int)$id[0]);
            return $product->getId();
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
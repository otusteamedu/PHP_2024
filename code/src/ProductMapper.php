<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11;

use PDO;
use PDOStatement;

class ProductMapper
{
    private PDO $pdo;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $findByIdStatement;
    private PDOStatement $findAllStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStatement = $pdo
            ->prepare('INSERT INTO products (name, price) VALUES (?, ?)');
        $this->updateStatement = $pdo
            ->prepare('UPDATE products SET name = ?, price = ? WHERE id = ?');
        $this->deleteStatement = $pdo->prepare('DELETE FROM products WHERE id = ?');
        $this->findByIdStatement = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $this->findAllStatement = $pdo->prepare('SELECT * FROM products');
    }

    public function insert(array $productArr): Product
    {
        $this->insertStatement->execute([
            $productArr['name'],
            $productArr['price'],
        ]);

        return new Product(
            intval($this->pdo->lastInsertId()),
            $productArr['name'],
            $productArr['price'],
        );
    }

    public function update(Product $product): void
    {
        $this->updateStatement->execute([
            $product->getName(),
            $product->getPrice(),
            $product->getId(),
        ]);
    }

    public function delete(int $productId): void
    {
        $this->deleteStatement->execute([$productId]);
    }

    public function findById(int $productId): Product
    {
        $this->findByIdStatement->setFetchMode(PDO::FETCH_CLASS, Product::class);
        $this->findByIdStatement->execute([$productId]);
        return $this->findByIdStatement->fetch();
    }

    public function findAll(): array
    {
        $this->findAllStatement->setFetchMode(PDO::FETCH_CLASS, Product::class);
        return $this->findAllStatement->fetchAll();
    }

}
<?php

declare(strict_types=1);

namespace Ikachko\Hw14\DataMapper;

use PDO;
use PDOStatement;

class ProductMapper
{
    private PDO          $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $this->selectAllStatement = $pdo->prepare("SELECT * FROM products");
        $this->insertStatement = $pdo->prepare("INSERT INTO products (title, price, remnant) values (:title, :price, :remnant)");
        $this->updateStatement = $pdo->prepare("UPDATE products SET title=:title, price=:price, remnant=:remnant where id=:id");
        $this->deleteStatement = $pdo->prepare("DELETE FROM products where id=:id");
    }

    public function findAll(): ProductCollection
    {
        $this->selectAllStatement->execute();
        $rawItems = $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);
        return new ProductCollection($rawItems, $this);
    }

    public function find(int $id): ?Product
    {

        if ($product = $this->getFromMap($id)) {
            return $product;
        }

        $this->selectStatement->execute([":id" => $id]);
        $arProduct = $this->selectStatement->fetch();
        $this->selectStatement->closeCursor();

        if (!empty($arProduct)) {
            return $this->createObject($arProduct);
        }

        return null;
    }

    public function insert(array $arProduct): Product
    {
        $this->insertStatement->execute([
            ":title" => $arProduct['title'],
            ":price" => $arProduct['price'],
            ":remnant" => $arProduct['remnant']
        ]);

        $arProduct['id'] = (int)$this->pdo->lastInsertId();
        $this->selectStatement->closeCursor();
        return $this->createObject($arProduct);
    }

    public function update(Product $product): bool
    {
        $isExecuted = $this->updateStatement->execute([
            ":title" => $product->getTitle(),
            ":price" => $product->getPrice(),
            ":remnant" => $product->getRemnant(),
            ":id" => $product->getId()
        ]);

        $this->updateStatement->closeCursor();
        $this->addToMap($product);

        return $isExecuted;
    }

    public function delete(Product $product): bool
    {
        if ($id = $product->getId()) {
            $isExecuted = $this->deleteStatement->execute([":id" => $id]);
            $this->deleteStatement->closeCursor();
            $this->removeFromMap($id);
            return $isExecuted;
        }

        return false;
    }

    public function createObject(array $arProduct): Product
    {
        if ($product = $this->getFromMap($arProduct['id'])) {
            return $product;
        }

        $product = new Product(
            $arProduct['id'],
            $arProduct['title'],
            $arProduct['price'],
            $arProduct['remnant']
        );

        $this->addToMap($product);

        return $product;
    }

    private function getFromMap($id): ?Product
    {
        $productWatcher = ProductWatcher::getInstance();
        return $productWatcher::get($id);
    }

    private function addToMap(Product $product): void
    {
        $productWatcher = ProductWatcher::getInstance();
        $productWatcher::add($product);
    }

    private function removeFromMap($id): void
    {
        $productWatcher = ProductWatcher::getInstance();
        $productWatcher::remove($id);
    }
}

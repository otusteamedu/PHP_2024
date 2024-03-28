<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Database\DataMapper\Product;

use loophp\collection\Collection;
use OutOfBoundsException;
use PDO;
use PDOStatement;
use RailMukhametshin\Hw\Database\IdentityMap;

class ProductMapper
{
    private PDO $pdo;
    private PDOStatement $selectAllStatement;
    private PDOStatement $selectByIdStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $updateStatement;

    private PDOStatement $deleteStatement;
    private IdentityMap $identityMap;

    public function __construct(PDO $pdo, IdentityMap $identityMap)
    {
        $this->pdo = $pdo;
        $this->selectAllStatement = $pdo->prepare($this->selectAllStatementQuery());
        $this->selectByIdStatement = $pdo->prepare($this->selectByIdStatementQuery());
        $this->insertStatement = $pdo->prepare($this->insertStatementQuery());
        $this->updateStatement = $pdo->prepare($this->updateStatementQuery());
        $this->deleteStatement = $pdo->prepare($this->deleteStatementQuery());
        $this->identityMap = $identityMap;
    }

    public function getAll(): Collection
    {
        $items = $this->selectAllStatement->fetchAll();
        $data = [];
        foreach ($items as $item) {
            $product = $this->createProduct($item);
            $data[] = $product;
        }

        return Collection::fromIterable($data);
    }

    public function getById(int $id): Product
    {
        if (!$this->identityMap->hasId($id)) {
            $this->selectByIdStatement->bindValue('id', $id);

            if ($this->selectByIdStatement->rowCount() == 0) {
                throw new OutOfBoundsException(
                    sprintf('Product #%s does not found', $id)
                );
            }

            $data = $this->selectByIdStatement->fetch();
            $product = $this->createProduct($data);
        }

        return $product ?? $this->identityMap->getById($id);
    }

    private function createProduct(array $data): Product
    {
        $product = new Product(
            $data['id'],
            $data['name'],
            $data['price']
        );

        $this->identityMap->set($product->getId(), $product);

        return $product;
    }

    public function insert(array $data): Product
    {
        $this->insertStatement->bindValue("name", $data["name"]);
        $this->insertStatement->bindValue("price", $data["price"]);
        $this->insertStatement->execute();

        $data["id"] = (int) $this->pdo->lastInsertId();
        return $this->createProduct($data);
    }

    public function delete(Product $product): bool
    {
        $this->identityMap->removeById($product->getId());
        return $this->deleteStatement->bindValue("id", $product->getId());
    }

    public function update(Product $product): Product
    {
        /** @var Product $oldProduct */
        $oldProduct = $this->identityMap->getById($product->getId());
        $willExecute = false;

        $this->updateStatement->bindValue("id", $product->getId());

        if ($oldProduct->getName() !== $product->getName()) {
            $this->updateStatement->bindValue("name", $product->getName());
            $willExecute = true;
        }

        if ($oldProduct->getPrice() !== $product->getPrice()) {
            $this->updateStatement->bindValue("price", $product->getPrice());
            $willExecute = true;
        }

        if ($willExecute) {
            $this->updateStatement->execute();
            $this->identityMap->set($product->getId(), $product);
        }

        return $product;
    }

    private function selectAllStatementQuery(): string
    {
        return "SELECT id, name, price FROM product";
    }

    private function selectByIdStatementQuery(): string
    {
        return "SELECT id, name, price FROM product where id = :id";
    }

    private function insertStatementQuery(): string
    {
        return "INSERT INTO product (name, price) VALUES (:name, :price)";
    }

    private function updateStatementQuery(): string
    {
        return "UPDATE product SET name = :name, price = :price WHERE id = :id";
    }

    private function deleteStatementQuery(): string
    {
        return "DELETE FROM product WHERE id = :id";
    }
}

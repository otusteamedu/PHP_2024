<?php

declare(strict_types=1);

namespace Ikachko\Hw14\DataMapper;

use PDO;
use PDOStatement;
use ReflectionClass;
use ReflectionProperty;

class ProductMapper
{
    private PDO          $pdo;
    private PDOStatement $selectStatement;
    private PDOStatement $selectAllStatement;
    private PDOStatement $insertStatement;
    private PDOStatement $deleteStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare("SELECT * FROM products WHERE id = :id");
        $this->selectAllStatement = $pdo->prepare("SELECT * FROM products LIMIT :limit OFFSET :offset");
        $this->insertStatement = $pdo->prepare("INSERT INTO products (title, price, remnant) values (:title, :price, :remnant)");
        $this->deleteStatement = $pdo->prepare("DELETE FROM products where id=:id");
    }

    public function findAll(int $limit = 50, int $offset = 0): ProductCollection
    {
        $this->selectAllStatement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $this->selectAllStatement->bindValue(':offset', $offset, PDO::PARAM_INT);
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
        $originalProduct = $this->getOriginalFromMap($product->getId());

        $reflection = new ReflectionClass($product);
        $properties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
        foreach ($properties as $property) {
            $propName = $property->getName();
            $getter = "get" . ucfirst($propName);
            if (!is_callable([$product, $getter]) || !is_callable([$originalProduct, $getter])) {
                continue;
            }

            $productPropValue = $product->$getter();
            $originalPropValue = $originalProduct->$getter();

            if ($productPropValue !== $originalPropValue) {
                $arParamsToUpdate[$propName] = $productPropValue;
            }
        }

        $isExecuted = true;
        if (!empty($arParamsToUpdate)) {
            $updateStatement = $this->getUpdateStatement($arParamsToUpdate);
            $arParamsToUpdate["id"] = $product->getId();
            $isExecuted = $updateStatement->execute($arParamsToUpdate);
            $updateStatement->closeCursor();
            $this->addToMap($product);
        }

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

    private function getOriginalFromMap($id): ?Product
    {
        $productWatcher = ProductWatcher::getInstance();
        return $productWatcher::getOriginal($id);
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

    private function getUpdateStatement(array $arParamsToUpdate): PDOStatement
    {
        foreach ($arParamsToUpdate as $paramName => $paramValue) {
            $arSetParams[] = $paramName . "=:" . $paramName;
        }

        $ddlQuery = "UPDATE products SET " . implode(", ", $arSetParams) . " where id=:id";
        return $this->pdo->prepare($ddlQuery);
    }
}

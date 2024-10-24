<?php

namespace App\Application\DataMapper;

use App\Application\DataMapper\Interface\DataMapperInterface;
use App\Domain\Entity\AbstractEntity;
use App\Domain\Entity\Product;
use App\Domain\Model\AbstractModel;
use App\Domain\Model\Product\ProductUpdate\ProductUpdateModel;
use App\Domain\Service\ConfigService;
use PDO;
use PDOStatement;

class ProductDataMapper implements DataMapperInterface
{
    private const TABLE = 'product';

    private PDO $pdo;

    public function __construct()
    {
        $config = ConfigService::class;
        $host =  $config::get('POSTGRES_CONTAINER_NAME');
        $db =  $config::get('POSTGRES_DB');

        $this->pdo = new PDO(
            "pgsql:host=$host;port=5432;dbname=$db;",
            $config::get('POSTGRES_USER'),
            $config::get('POSTGRES_PASSWORD'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    public function findById(string $id): ?Product
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare(
            'SELECT * FROM ' . self::TABLE . ' WHERE id = ?'
        );
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        $product = null;
        if ($result) {
            $product = new Product(
                $result['id'],
                $result['title'],
                $result['sku'],
                $result['category'],
                $result['price'],
                $result['volume'],
            );
        }

        return $product;
    }

    /**
     * @param array $criteriaArray
     * @return Product[]|null
     */
    public function findByCriteria(array $criteriaArray): ?array
    {
        $whereString = '';
        $productArray = [];

        foreach ($criteriaArray as $key => $value) {
            $whereString .=  $key . ' = ' . "'$value'" . ' AND ';
        }
        $whereString = substr($whereString, 0, -5);

        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE ' . $whereString;

        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare($query);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultArray = $stmt->fetchAll();

        foreach ($resultArray as $result) {
            $product = new Product(
                $result['id'],
                $result['title'],
                $result['sku'],
                $result['category'],
                $result['price'],
                $result['volume'],
            );
            $productArray[] = $product;
        }

        return $productArray;
    }

    /**
     * @var Product $product
     */
    public function insert(AbstractEntity $product): ?Product
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare(
            'INSERT INTO ' . self::TABLE
            . ' (id, title, sku, category, price, volume) VALUES (?, ?, ?, ?, ?, ?)'
        );

        $error = '';
        try {
            $stmt->execute(
                [
                    $product->getId(),
                    $product->getTitle(),
                    $product->getSku(),
                    $product->getCategory(),
                    $product->getPrice(),
                    $product->getVolume(),
                ]
            );
        } catch (\PDOException $e) {
            $error = $e->getMessage();
        }

        return $error ? null : $this->findById($product->getId());
    }

    /**
     * @var ProductUpdateModel $model
     */
    public function update(AbstractModel $model): bool
    {
        $valueString = '';

        foreach ($model as $key => $value) {
            if ($value) {
                $valueString .= $key . ' = ' . "'$value'" . ', ';
            }
        }
        $valueString = substr($valueString, 0, -2);

        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare(
            'UPDATE ' . self::TABLE . ' SET ' . $valueString . ' WHERE id = ?'
        );

        return $stmt->execute([$model->id]);
    }

    /**
     * @var Product $product
     */
    public function delete(AbstractEntity $product): bool
    {
        /** @var PDOStatement $stmt */
        $stmt = $this->pdo->prepare(
            'DELETE FROM ' . self::TABLE . ' WHERE id = ?'
        );

        return $stmt->execute([$product->getId()]);
    }
}

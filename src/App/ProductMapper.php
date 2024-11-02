<?php

namespace Komarov\Hw14\App;

use PDO;

class ProductMapper
{
    private PDO $db;
    private IdentityMap $identityMap;

    public function __construct(PDO $db)
    {
        $this->db = $db;
        $this->identityMap = new IdentityMap();
    }

    public function getAllProducts(): array
    {
        $stmt = $this->db->query("SELECT * FROM products");
        $products = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $product = $this->identityMap->get($row['id']);
            if ($product === null) {
                $product = new Product(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['price']
                );
                $this->identityMap->add($row['id'], $product);
            }
            $products[] = $product;
        }

        return $products;
    }

    public function getProductById(int $id): ?Product
    {
        $product = $this->identityMap->get($id);

        if ($product === null) {
            $stmt = $this->db->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $product = new Product(
                    $row['id'],
                    $row['name'],
                    $row['description'],
                    $row['price']
                );
                $this->identityMap->add($row['id'], $product);
            }
        }

        return $product;
    }
}

<?php

namespace App\Mappers;

use App\Connections\DatabaseConnection;
use App\Entities\Order;
use PDO;

class OrderMapper extends AbstractMapper
{
    public static function findById(int $id): ?Order
    {
        $statement = self::$pdo->prepare('SELECT * FROM orders WHERE id = :id');
        $statement->execute(['id' => $id]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Order($row['id'], $row['user_id'], $row['product_name'], $row['amount']);
        }

        return null;
    }

    public static function findByUserId(int $userId): array
    {
        $statement = self::$pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
        $statement->execute(['user_id' => $userId]);
        $rows = $statement->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];

        foreach ($rows as $row) {
            $orders[] = new Order($row['id'], $row['user_id'], $row['product_name'], $row['amount']);
        }

        return $orders;
    }

    public static function save(Order $order): void
    {
        if ($order->getId()) {
            $statement = self::$pdo->prepare('UPDATE orders SET product_name = :product_name, amount = :amount WHERE id = :id');
            $statement->execute([
                'product_name' => $order->getProductName(),
                'amount' => $order->getAmount(),
                'id' => $order->getId()
            ]);
        } else {
            $statement = self::$pdo->prepare('INSERT INTO orders (user_id, product_name, amount) VALUES (:user_id, :product_name, :amount)');
            $statement->execute([
                'user_id' => $order->getUserId(),
                'product_name' => $order->getProductName(),
                'amount' => $order->getAmount()
            ]);
            $order->setId(self::$pdo->lastInsertId());
        }
    }
}

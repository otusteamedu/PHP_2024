<?php

declare(strict_types=1);

namespace App\DataMapper;

use App\Order;
use App\User;
use PDO;

class OrderDataMapper
{
    public function __construct(private \PDO $db)
    {
    }

    /**
     * @param User $user
     * @return Order[]
     */
    public function getUserOrders(User $user): array
    {
        $query = $this->db->prepare("SELECT * FROM `orders` WHERE `user_id` = :user_id");
        $query->bindValue(':user_id', $user->getId());
        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return array_map(
            static fn (array $row) => new Order((int) $row['id'], (int) $row['sum']),
            $rows
        );
    }

    public function getOrderById(int $orderId): Order
    {
        $query = $this->db->prepare("SELECT * FROM `orders` WHERE `id` = :order_id");
        $query->bindValue(':order_id', $orderId);
        $row = $query->fetch(PDO::FETCH_ASSOC);
        if (empty($row)) {
            throw new \DomainException('Order not found');
        }
        return new Order((int) $row['id'], (int) $row['sum']);
    }

    public function addOrderForUser(Order $order, User $user): int
    {
        $this->db->prepare("INSERT INTO `orders` (`sum`, `user_id`) VALUES (:sum, :user_id)")
            ->execute([':sum' => $order->getSum(), ':user_id' => $user->getId()]);
        return (int) $this->db->lastInsertId();
    }

    public function updateOrder(Order $order): void
    {
        $this->db->prepare("UPDATE `orders` SET `sum` = :sum, `user_id` = :user_id WHERE `id` = :id")
            ->execute([':sum' => $order->getSum(), ':user_id' => $order->getUser()->getId()]);
    }
}

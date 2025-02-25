<?php

namespace Infrastructure\Persistence;

use Domain\Entities\Ticket;
use Domain\Repositories\TicketRepositoryInterface;
use Infrastructure\Database\DatabaseConnection;
use PDO;

class TicketRepository implements TicketRepositoryInterface
{
    private PDO $connection;
    public const string TABLE = 'tickets';

    public function __construct()
    {
        $this->connection = DatabaseConnection::getInstance()->getConnection();
    }

    public function findAll(): array
    {
        $stmt = $this->connection->query("SELECT * FROM " . self::TABLE);
        return $stmt->fetchAll(PDO::FETCH_CLASS, Ticket::class);
    }

    public function findById(int $id): ?Ticket
    {
        $stmt = $this->connection->prepare("SELECT * FROM " . self::TABLE . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Ticket::class) ?: null;
    }

    public function save(Ticket $entity): false|string
    {
        if ($entity->id) {
            $stmt = $this->connection->prepare("UPDATE " . self::TABLE . " SET show_id = :show_id, seat = :seat, price = :price, available = :available WHERE id = :id");
            $stmt->execute([
                'id' => $entity->id,
                'show_id' => $entity->show_id,
                'seat' => $entity->seat,
                'price' => $entity->price,
                'available' => $entity->available,
            ]);
        } else {
            $stmt = $this->connection->prepare("INSERT INTO " . self::TABLE . " (show_id, seat, price, available) VALUES (:show_id, :seat, :price, :available)");
            $stmt->execute([
                'show_id' => $entity->show_id,
                'seat' => $entity->seat,
                'price' => $entity->price,
                'available' => $entity->available,
            ]);
        }

        return $this->connection->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->connection->prepare("DELETE FROM " . self::TABLE . " WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}

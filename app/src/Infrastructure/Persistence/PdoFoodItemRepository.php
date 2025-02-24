<?php

declare(strict_types=1);

namespace Otus\Hw16\Infrastructure\Persistence;

use Otus\Hw16\Domain\Entity\FoodItem;
use Otus\Hw16\Domain\Entity\OrderStatusHistory;
use Otus\Hw16\Domain\Repository\FoodItemRepositoryInterface;
use Otus\Hw16\Infrastructure\Service\PdoDatabaseService;
use PDO;

class PdoFoodItemRepository implements FoodItemRepositoryInterface
{
    private PDO $pdo;

    public function __construct(PdoDatabaseService $pdoDatabaseService)
    {
        $this->pdo = $pdoDatabaseService->getPdo();
        $this->initializeDatabase();
    }

    private function initializeDatabase(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS food_items (
                id SERIAL PRIMARY KEY,
                type VARCHAR(50) NOT NULL,
                ingredients JSON NOT NULL
            )
        ");
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS order_status_history (
                id SERIAL PRIMARY KEY,
                food_item_id INTEGER NOT NULL REFERENCES food_items(id),
                status VARCHAR(50) NOT NULL,
                created_at TIMESTAMP NOT NULL
            )
        ");
    }

    public function save(FoodItem $foodItem): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO food_items (type, ingredients) VALUES (:type, :ingredients) RETURNING id");
        $stmt->execute([
            'type' => $foodItem->getType(),
            'ingredients' => json_encode($foodItem->getIngredients())
        ]);
        return $stmt->fetchColumn();
    }

    public function saveStatusHistory(OrderStatusHistory $history): void
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO order_status_history (food_item_id, status, created_at) 
            VALUES (:food_item_id, :status, :created_at) 
            RETURNING id
        ");
        $stmt->execute([
            'food_item_id' => $history->getFoodItemId(),
            'status' => $history->getStatus(),
            'created_at' => $history->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        $id = $stmt->fetchColumn();
        $history->setId($id);
    }
}

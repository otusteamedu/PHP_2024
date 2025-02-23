<?php

namespace Otus\Hw16\Infrastructure\Service;

use Otus\Hw16\Domain\Entity\FoodItem;
use Otus\Hw16\Domain\Service\CookingServiceInterface;
use PDO;

class PdoDatabaseService implements CookingServiceInterface
{
    private PDO $pdo;

    public function __construct(string $host, string $port, string $dbname, string $user, string $password)
    {
        $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
        $this->pdo = new PDO($dsn, $user, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    public function cook(FoodItem $foodItem): bool
    {
        return true; // Логика приготовления
    }
}

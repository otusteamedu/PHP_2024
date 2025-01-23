<?php

declare(strict_types=1);

namespace App;

use App\DB\DbConnection;

class AbstractGateway
{
    protected ?\PDO $dbConnection;
    protected array $identityMap = [];
    protected static string $table = '';

    public function __construct()
    {
        if (empty(static::$table)) {
            throw new \InvalidArgumentException('Property $table must be defined in class ' . get_called_class());
        }

        $this->dbConnection = DbConnection::getInstance();
    }


    public function delete(int $id): bool
    {
        $stmt = $this->dbConnection->prepare("DELETE FROM " . static::$table . " WHERE id = :id");

        return $stmt->execute([':id' => $id]);
    }
}

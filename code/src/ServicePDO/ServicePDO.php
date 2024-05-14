<?php
declare(strict_types=1);

namespace App\ServicePDO;

use PDO;
use PDOStatement;

class ServicePDO
{
    private PDO $pdo;

    public function __construct() {
        $this->pdo = new PDO(
            "pgsql:host=".getenv("POSTGRES_HOST").";dbname=".getenv("POSTGRES_DATABASE").";",
            getenv("POSTGRES_USER"),
            getenv("POSTGRES_PASSWORD")
        );
    }

    public function prepare(string $string): PDOStatement
    {
        return $this->pdo->prepare($string);
    }
}
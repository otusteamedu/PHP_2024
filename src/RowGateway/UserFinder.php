<?php

declare(strict_types=1);

namespace AShutov\Hw17\RowGateway;

use PDO;
use PDOStatement;

class UserFinder
{
    private PDO $pdo;
    private PDOStatement $selectStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );
    }

    public function getById(int $id): Users
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);
        $result = $this->selectStatement->fetch();

        return (new Users($this->pdo))
            ->setId($result['id'])
            ->setName($result['name'])
            ->setAge($result['age'])
            ->setJob($result['job'])
            ->setDepartmentId($result['department_id']);
    }
}

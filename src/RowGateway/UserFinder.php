<?php

declare(strict_types=1);

//https://github.com/ab-budaev/otus-php-database-patterns-lesson/blob/master/src/RowGateway
namespace Skudashkin\Hw16\RowGateway;

use PDO;
use PDOStatement;

class UserFinder
{
    private PDO          $pdo;

    private PDOStatement $selectStatement;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $pdo->prepare(
            'SELECT * FROM users WHERE id = ?'
        );
    }

    public function findOneById(int $id): User
    {
        $this->selectStatement->setFetchMode(PDO::FETCH_ASSOC);
        $this->selectStatement->execute([$id]);

        $result = $this->selectStatement->fetch();

        return (new User($this->pdo))
            ->setId($result['id'])
            ->setLastName($result['last_name'])
            ->setFirstName($result['first_name'])
            ->setEmail($result['email']);
    }
}
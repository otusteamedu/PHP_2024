<?php
declare(strict_types=1);

namespace App\ActiveRecord;


use App\ServicePDO\ServicePDO;
use PDO;
use PDOStatement;

class Sessions
{
    const TABLE_NAME = 'sessions';

    private ServicePDO $pdo;
    private PDOStatement $selectAllStatement;

    public function __construct(ServicePDO $pdo) {
        $this->pdo = $pdo;
        $this->selectAllStatement = $pdo->prepare("SELECT date FROM ".self::TABLE_NAME." WHERE film_id = ? LIMIT ?");
    }

    public function selectAll(string $film_id, int $limit): array
    {
        $this->selectAllStatement->execute([$film_id, $limit]);
        return $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);
    }
}
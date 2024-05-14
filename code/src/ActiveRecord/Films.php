<?php
declare(strict_types=1);

namespace App\ActiveRecord;


use App\ServicePDO\ServicePDO;
use PDO;
use PDOStatement;

class Films
{
    const TABLE_NAME = 'films';
    private ?string $id = null;
    private ?string $name = null;
    private ?array $session_dates = [];

    private ServicePDO $pdo;
    private PDOStatement $insertStatement;
    private PDOStatement $deleteStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $selectOneStatement;
    private PDOStatement $selectAllStatement;

    public function __construct(ServicePDO $pdo) {
        $this->pdo = $pdo;
        $this->insertStatement = $pdo->prepare("INSERT INTO ".self::TABLE_NAME." (id,name) VALUES (?,?)");
        $this->deleteStatement = $pdo->prepare("DELETE FROM ".self::TABLE_NAME." WHERE id =?");
        $this->updateStatement = $pdo->prepare("UPDATE ".self::TABLE_NAME." SET name =? WHERE id =?");
        $this->selectOneStatement = $pdo->prepare("SELECT * FROM ".self::TABLE_NAME." WHERE id =?");
        $this->selectAllStatement = $pdo->prepare("SELECT * FROM ".self::TABLE_NAME);
    }

    public function selectOne(string $id) {
        $this->id = $id;
        $this->selectOneStatement->execute([$id]);
        $result = $this->selectOneStatement->fetch(PDO::FETCH_ASSOC);
        if (empty($this->session_dates)) {
            $this->session_dates = $this->getSessionDates();
            $result['sessions_dates'] = $this->session_dates;
        }
        return $result;
    }

    public function insert(array $arguments): bool
    {
        $this->insertStatement->execute($arguments);
        return true;
    }

    public function delete(string $id): bool
    {
        $this->deleteStatement->execute([$id]);
        return true;
    }

    public function update($id,$name): bool
    {
        $this->updateStatement->execute([
            $this->name = $name,
            $this->id = $id
        ]);
        return true;
    }

    public function selectAll(): array
    {
        $this->selectAllStatement->execute();
        return $this->selectAllStatement->fetchAll(PDO::FETCH_ASSOC);
    }

    # Lazy loading
    private function getSessionDates(int $limit = 100): ?array
    {
        $sessions = new Sessions($this->pdo);
        $this->session_dates = $sessions->selectAll($this->id,$limit);
        return $this->session_dates;
    }
}
<?php

declare(strict_types=1);

namespace Kagirova\Hw31\Infrastucture\Database;

use Kagirova\Hw31\Domain\Config\Config;
use Kagirova\Hw31\Domain\RepositoryInterface\StorageInterface;

class PostgresStorage implements StorageInterface
{
    private \PDO $pdo;

    public function __construct(private Config $config)
    {
        $this->connect();
    }

    public function connect()
    {
        $dsn = "pgsql:host=" . $this->config->postgresHost . ";port=" . $this->config->postgresPort . ";dbname=" . $this->config->postgresDatabase;
        $this->pdo = new \PDO($dsn, $this->config->postgresUser, $this->config->postgresPassword);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function addMessage(string $message)
    {
        $sql = 'INSERT INTO message (message, status_id)  VALUES (:message, :status_id)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':message', $message);
        $stmt->bindValue(':status_id', 1);
        $stmt->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function updateStatus(int $messageId, int $status)
    {
        $sql = 'UPDATE message SET status_id = :status_id  WHERE id=:message_id';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':message_id', $messageId);
        $stmt->bindValue(':status_id', $status);
        $stmt->execute();
    }

    public function getStatus(int $messageId)
    {
        $sql = 'SELECT name FROM status WHERE id=(SELECT status_id FROM message WHERE id=:id)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':id', $messageId);
        $stmt->execute();

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (empty($row)) {
            throw new \Exception('Data not found', 404);
        }
        return $row['name'];
    }
}

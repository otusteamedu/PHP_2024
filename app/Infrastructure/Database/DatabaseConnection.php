<?php

declare(strict_types=1);

namespace App\Infrastructure\Database;

use App\Infrastructure\Traits\SingletonTrait;
use PDO;

final class DatabaseConnection
{
    use SingletonTrait;
    private ?PDO $connection = null;

    protected function getConnection(): ?PDO
    {
        if (is_null($this->connection)) {
            $this->connection = new PDO(
                $this->buildDsn(env('DB_HOST'), env('DB_DATABASE')),
                env('DB_USERNAME'),
                env('DB_PASSWORD'),
            );

            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return $this->connection;
    }

    private function buildDsn(string $dbHost, string $dbName): string
    {
        return sprintf(
            '%s:host=%s;port=5432;dbname=%s',
            'pgsql',
            $dbHost,
            $dbName,
        );
    }

    public function query(string $sql, array $params = []): false|\PDOStatement
    {
        $pdoStatement = $this->getConnection()->prepare($sql);
        $pdoStatement->execute($params);

        return $pdoStatement;
    }

    /**
     * @param string $sql
     * @param array $params
     * @param string|null $className
     * @return false|array
     */
    public function queryAll(string $sql, array $params = [], string $className = null): false|array
    {
        $pdoStatement = $this->query($sql, $params);

        if (!empty($className)) {
            $pdoStatement->setFetchMode(
                PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE,
                $className
            );
        }

        return $pdoStatement->fetchAll();
    }

    public function execute(string $sql, array $params = []): int
    {
        return $this->query($sql, $params)->rowCount();
    }

    public function lastInsertId(): false|int
    {
        return (int)$this->getConnection()->lastInsertId();
    }
}

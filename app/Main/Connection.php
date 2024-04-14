<?php

declare(strict_types=1);

namespace App\Main;

use App\Traits\Singleton;
use PDO;

final class Connection
{

    use Singleton;
    private ?PDO $connection = null;

    protected function getConnection(): ?PDO
    {
        $env = parse_ini_file(__DIR__ . '/../../.env');

        if (is_null($this->connection)) {
            $this->connection = new PDO(
                $this->buildDsn($env['DB_HOST'], $env['DB_DATABASE']),
                $env['DB_USERNAME'],
                $env['DB_PASSWORD'],
            );

            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }

        return $this->connection;
    }

    private function buildDsn(string $dbHost, string $dbName): string
    {
        return sprintf(
            '%s:host=%s;dbname=%s;charset=%s',
            'mysql',
            $dbHost,
            $dbName,
            'utf8'
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
     * @param string|null $className - class name для преобразования в объект
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

    public function lastInsertId(): false|string
    {
        return $this->getConnection()->lastInsertId();
    }
}

<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusDatabasePatternApp\Services;

use PDOException;
use Dotenv;
use PDO;

class DatabaseService
{
    /** @var PDO */
    private PDO $pdo;

    /** @var ?DatabaseService */
    private static ?DatabaseService $instance = null;

    private function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();

        try {
            $this->pdo = new PDO(
                'pgsql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_DATABASE'],
                $_ENV['DB_USERNAME'],
                $_ENV['DB_PASSWORD']
            );
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    /**
     * Метод возвращает параметр подключения к БД PDO
     *
     * @return PDO
     */
    public function getPdo(): PDO
    {
        return $this->pdo;
    }

    /**
     * Метод формирует запрос обращения к БД
     *
     * @param string $sql
     * @param array $params
     * @param string $className
     *
     * @return array|null
     */
    public function query(string $sql, array $params = [], string $className = 'stdClass'): ?array
    {
        $sth = $this->pdo->prepare($sql);
        $result = $sth->execute($params);

        if (false === $result) {
            return null;
        }

        return $sth->fetchAll(PDO::FETCH_CLASS, $className);
    }

    /**
     * Метод проверяет был ли создан уже
     * объект или нет
     *
     * @return static
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

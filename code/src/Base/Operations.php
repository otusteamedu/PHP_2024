<?php

namespace src\Base;

use Exception;
use PDO;
use PDOException;

class Operations
{
    private PDO $pdo;

    public function __construct()
    {
        $pdoClass = new \src\Base\Pdo('localhost', 'test-wp', 'root', 'root');
        try {
            $this->pdo = $pdoClass->connect();
        } catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    public function insertGenre($name): void
    {
        $sql = 'INSERT INTO genre (name) VALUES(:name)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $name);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertMovie($title, $duration, $description, $country, $year): void
    {
        $sql = 'INSERT INTO movie (title, duration, description, country, year) VALUES(:title, :duration, :description, :country, :year)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':duration', $duration);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':country', $country);
        $stmt->bindValue(':year', $year);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function insertHall($name, $rows, $columns): void
    {
        $sql = 'INSERT INTO hall (name, rows, columns) VALUES(:name, :rows, :columns)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':rows', $rows);
        $stmt->bindValue(':columns', $columns);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createTicket($session_id, $row, $columnNumber, $price): bool|string
    {
        $sql = 'INSERT INTO ticket (session_id, row, columnNumber, price) VALUES(:session_id, :row, :columnNumber, :price)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':session_id', $session_id);
        $stmt->bindValue(':row', $row);
        $stmt->bindValue(':columnNumber', $columnNumber);
        $stmt->bindValue(':price', $price);

        try {
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->pdo->lastInsertId();
    }

    public function createSession($movie, $hall, $dateStart, $dateEnd, $basePrice): bool|string
    {
        $sql = 'INSERT INTO session (movie, hall, dateStart, dateEnd, basePrice) VALUES (:movie, :hall, :dateStart, :dateEnd, :basePrice)';
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindValue(':movie', $movie);
        $stmt->bindValue(':hall', $hall);
        $stmt->bindValue(':dateStart', $dateStart);
        $stmt->bindValue(':dateEnd', $dateEnd);
        $stmt->bindValue(':basePrice', $basePrice);

        try {
            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public function getSessions(): bool|array
    {
        $sth = $this->pdo->query('SELECT id, h.name, h.rows, h.columns, basePrice FROM session JOIN hall as h ON session.hall = h.name');

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMovies(): bool|array
    {
        $sth = $this->pdo->query('SELECT id, duration FROM movie');

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHalls(): bool|array
    {
        $sth = $this->pdo->query('SELECT name FROM hall');

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

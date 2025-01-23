<?php

declare(strict_types=1);

namespace App;

use App\DB\DbConnection;

class MovieDirectorGateway extends AbstractGateway
{
    protected static string $table = 'movie_directors';
    protected static array $identityMap = [];

    public function findById($id)
    {
        if (isset(static::$identityMap[$id])) {
            echo 'From identityMap' . PHP_EOL;
            return static::$identityMap[$id];
        }

        $stmt = $this->dbConnection->prepare("SELECT * FROM " . static::$table . " WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($row) {
            $movieDirector = new MovieDirector($row['id'], $row['name'], $row['orig_name'], $row['date_of_birth']);
            static::$identityMap[$id] = $movieDirector;
            return $movieDirector;
        }

        return null;
    }

    public function findAll(): array
    {
        $stmt = $this->dbConnection->query("SELECT * FROM " . static::$table);
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $results = [];
        foreach ($rows as $row) {
            $results[] = (new MovieDirector(...$row))->toArray();
        }

        return $results;
    }

    public function insert(MovieDirector $movieDirector): bool
    {
        $stmt = $this->dbConnection->prepare("INSERT INTO " . static::$table . " (name, orig_name, date_of_birth) VALUES (:name, :orig_name, :date_of_birth)");
        return $stmt->execute([
            ':name' => $movieDirector->getName(),
            ':orig_name' => $movieDirector->getOrigName(),
            ':date_of_birth' => $movieDirector->getDateOfBirth(),
        ]);
    }

    public function update(MovieDirector $movieDirector): bool
    {
        $stmt = $this->dbConnection->prepare("UPDATE " . static::$table . " SET name = :name, orig_name = :orig_name, date_of_birth = :date_of_birth");
        return $stmt->execute([
            ':name' => $movieDirector->getName(),
            ':orig_name' => $movieDirector->getOrigName(),
            ':date_of_birth' => $movieDirector->getDateOfBirth(),
        ]);
    }
}

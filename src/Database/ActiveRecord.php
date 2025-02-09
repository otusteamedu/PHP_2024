<?php

namespace KRudenko\Otus\Database;

use KRudenko\Otus\Exceptions\DatabaseException;
use PDO;
use PDOException;

abstract class ActiveRecord
{
    protected static ?PDO $pdo = null;
    protected static string $tableName;
    protected static array $identityMap = [];
    protected array $originalData = [];
    protected array $changedFields = [];

    public static function setConnection(PDO $pdo): void
    {
        self::$pdo = $pdo;
    }

    public static function findAll(int $limit = 100, int $offset = 0): Collection
    {
        self::checkConnection();

        try {
            $stmt = self::$pdo->query("SELECT * FROM \"" . static::$tableName . "\" LIMIT $limit OFFSET $offset");
            $rows = $stmt->fetchAll();
        } catch (PDOException $e) {
            throw new DatabaseException("Query failed: " . $e->getMessage());
        }

        return self::hydrateCollection($rows);
    }

    public static function findById(int $id): ?self
    {
        if ($obj = static::getFromIdentityMap($id)) {
            return $obj;
        }

        self::checkConnection();

        try {
            $stmt = self::$pdo->prepare("SELECT * FROM \"" . static::$tableName . "\" WHERE id = ?");
            $stmt->execute([$id]);

            if ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $obj = new static($data);
                static::addToIdentityMap($obj);
                return $obj;
            }
        } catch (PDOException $e) {
            throw new DatabaseException("Query failed: " . $e->getMessage());
        }

        return null;
    }

    private static function hydrateCollection(array $rows): Collection
    {
        $collection = [];
        foreach ($rows as $row) {
            $collection[] = self::hydrateEntity($row);
        }
        return new Collection($collection);
    }

    private static function hydrateEntity(array $data): self
    {
        $id = $data['id'] ?? null;

        if ($id && ($entity = static::getFromIdentityMap($id))) {
            return $entity->sync($data);
        }

        $entity = new static($data);
        static::addToIdentityMap($entity);
        return $entity;
    }

    public function sync(array $data): self
    {
        $currentData = get_object_vars($this);

        foreach ($data as $key => $value) {
            // Обновляем только существующие свойства
            if (array_key_exists($key, $currentData) && $key !== 'id') {
                $this->$key = $value;
            }
        }

        $this->changedFields = [];

        return $this;
    }

    protected static function getFromIdentityMap($id): ?self
    {
        return static::$identityMap[$id] ?? null;
    }

    protected static function addToIdentityMap(self $obj): void
    {
        static::$identityMap[$obj->id] = $obj;
    }

    private static function checkConnection(): void
    {
        if (!self::$pdo) {
            throw new DatabaseException("Database connection not initialized");
        }
    }

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        if (isset($data['id'])) {
            unset($data['id']);
        }

        $this->originalData = $this->toArray();
        $this->changedFields = [];
    }

    public function __set(string $name, $value): void
    {
        if (property_exists($this, $name)) {
            $this->trackChanges($name, $value);
            $this->$name = $value;
        }
    }

    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        return null;
    }

    protected function trackChanges(string $field, $newValue): void
    {
        $currentValue = $this->originalData[$field] ?? null;

        if ($currentValue !== $newValue && !in_array($field, $this->changedFields)) {
            $this->changedFields[] = $field;
        } elseif ($currentValue === $newValue && $key = array_search($field, $this->changedFields)) {
            unset($this->changedFields[$key]);
        }
    }

    public function save(): void
    {
        $this->id ? $this->update() : $this->insert();
    }

    private function insert(): void
    {
        $columns = array_filter(get_object_vars($this), fn($k) => $k !== 'id', ARRAY_FILTER_USE_KEY);
        $fields = implode(', ', array_keys($columns));
        $placeholders = ':' . implode(', :', array_keys($columns));

        self::checkConnection();

        try {
            $stmt = self::$pdo->prepare("
                INSERT INTO \"" . static::$tableName . "\" ($fields)
                VALUES ($placeholders)
            ");

            $stmt->execute($columns);
            $this->id = self::$pdo->lastInsertId();
            static::addToIdentityMap($this);
        } catch (PDOException $e) {
            throw new DatabaseException("Query failed: " . $e->getMessage());
        }
    }

    private function update(): void
    {
        if (empty($this->changedFields)) {
            return;
        }

        $setParts = [];
        $params = ['id' => $this->id];

        foreach ($this->changedFields as $field) {
            $setParts[] = "$field = :$field";
            $params[$field] = $this->$field;
        }
        $set = implode(', ', $setParts);

        self::checkConnection();

        try {
            $stmt = self::$pdo->prepare("
                UPDATE \"" . static::$tableName . "\"
                SET $set
                WHERE id = :id
            ");

            $stmt->execute($params);
        } catch (PDOException $e) {
            throw new DatabaseException("Query failed: " . $e->getMessage());
        }

        $this->originalData = $this->toArray();
        $this->changedFields = [];
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function delete(): void
    {
        self::checkConnection();

        try {
            $stmt = self::$pdo->prepare("DELETE FROM \"" . static::$tableName . "\" WHERE id = ?");
            $stmt->execute([$this->id]);
            unset(static::$identityMap[$this->id]);
        } catch (PDOException $e) {
            throw new DatabaseException("Query failed: " . $e->getMessage());
        }
    }
}

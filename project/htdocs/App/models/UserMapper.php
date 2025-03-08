<?php

namespace App\Models;

use PDO;

class UserMapper {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }
    // Преобразует массив в объект User
    private function hydrate(array $data): User {
        return new User(
            $data['id'],
            $data['name'],
            $data['email'],
            $data['created_at']
        );
    }

    // Получает всех пользователей из базы данных
    public function findAll(): array {
        $query = "SELECT * FROM users";
        $stmt = $this->pdo->query($query);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($rows as $row) {
            $users[] = $this->hydrate($row);
        }

        return $users; // Возвращает коллекцию объектов User
    }

    // Получает пользователя по ID
    public function findById(int $id): ?User {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $this->hydrate($row);
        }

        return null; // Если пользователь не найден
    }

    // Создает нового пользователя
    public function insert(User $user): int {
        $query = "INSERT INTO users (name, email, created_at) VALUES (:name, :email, NOW())";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([
            'name' => $user->getName(),
            'email' => $user->getEmail()
        ]);

        return $this->pdo->lastInsertId(); // Возвращает ID созданного пользователя
    }

    // Обновляет пользователя
    public function update(User $user): bool {
    $dirtyFields = $user->getDirtyFields();
    
    if (empty($dirtyFields)) {
        return false; // Нечего обновлять
    }

    $setClauses = [];
    $params = ['id' => $user->getId()];
    
    foreach ($dirtyFields as $field) {
        $getter = 'get' . ucfirst($field);
        $setClauses[] = "$field = :$field";
        $params[$field] = $user->$getter();
    }

    $query = "UPDATE users SET " . implode(', ', $setClauses) . " WHERE id = :id";
    $stmt = $this->pdo->prepare($query);
    $result = $stmt->execute($params);
    
    if ($result) {
        $user->resetDirtyFields(); // Сброс после успешного обновления
    }
    
    return $result;
}

    // Удаляет пользователя
    public function delete(int $id): bool {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}

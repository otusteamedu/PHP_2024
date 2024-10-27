<?php
// Класс User, реализующий паттерн Active Record.
class User {
    private $id;
    private $name;
    private $email;

    private static $db;

    public function __construct($name, $email, $id = null) {
        $this->name = $name;
        $this->email = $email;
        $this->id = $id;
    }

    public static function setDb(PDO $database) {
        self::$db = $database;
    }

    public function save() {
        if ($this->id) {
            $existingUser = self::findById($this->id);
            if ($existingUser->getName() !== $this->name || $existingUser->getEmail() !== $this->email) {
                $stmt = self::$db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
                $stmt->execute([$this->name, $this->email, $this->id]);
            }
        } else {
            $stmt = self::$db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$this->name, $this->email]);
            $this->id = self::$db->lastInsertId();
        }
    }

    public static function findById($id) {
        $stmt = self::$db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return new self($result['name'], $result['email'], $result['id']);
    }

    public static function findAll($limit = 100, $offset = 0) {
        $stmt = self::$db->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $users = [];

        foreach ($results as $result) {
            $users[] = new self($result['name'], $result['email'], $result['id']);
        }

        return $users;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }
}

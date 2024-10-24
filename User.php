<?php
//Класс User, реализующий паттерн Active Record.
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
            $stmt = self::$db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
            $stmt->execute([$this->name, $this->email, $this->id]);
        } else {
            $stmt = self::$db->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->execute([$this->name, $this->email]);
            $this->id = self::$db->lastInsertId();
        }
    }

    public static function findAll() {
        $stmt = self::$db->query("SELECT * FROM users");
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

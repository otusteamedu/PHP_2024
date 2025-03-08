<?php

namespace App\Models;

class User {
    private $id;
    private $name;
    private $email;
    private $createdAt;
    private $originalData = [];
    
    public function __construct($id = null, $name = '', $email = '', $createdAt = '') {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;

         // Сохраняем исходные данные
        $this->originalData = [
            'name' => $name,
            'email' => $email,
            'createdAt' => $createdAt,
        ];
    }

    // Геттеры и сеттеры
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }
     // Проверка, изменилось ли поле
    public function hasChanged($field): bool {
        return $this->$field !== $this->originalData[$field];
    }

    // Сброс оригинальных данных после обновления
    public function resetOriginalData() {
        $this->originalData = [
            'name' => $this->name,
            'email' => $this->email,
            'createdAt' => $this->createdAt,
        ];
    }
}

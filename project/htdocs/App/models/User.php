<?php

namespace App\Models;

class User {
    private $id;
    private $name;
    private $email;
    private $createdAt;
    
    public function __construct($id = null, $name = '', $email = '', $createdAt = '') {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->createdAt = $createdAt;
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
}

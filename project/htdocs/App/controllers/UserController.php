<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\UserMapper;

class UserController {
    private $userMapper;

    public function __construct() {
        // Инициализация подключения к базе данных
        $dbConfig = require __DIR__ . '/../../App/config/database.php';
        $pdo = new \PDO($dbConfig['dsn'], $dbConfig['username'], $dbConfig['password']);
        $this->userMapper = new UserMapper($pdo);
    }

    // Отображение списка пользователей
    public function index() {
        $users = $this->userMapper->findAll();
        include __DIR__ . '/../../App/views/users_list.php';
    }

    // Создание нового пользователя
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $newUser = new User(null, $_POST['name'], $_POST['email']);
            $this->userMapper->insert($newUser);
            header('Location: /users');
            exit;
        }

        include __DIR__ . '/../../App/views/user_form.php';
    }

    // Редактирование пользователя
    public function edit() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }

        $user = $this->userMapper->findById($id);
        if (!$user) {
            echo "Пользователь не найден.";
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $this->userMapper->update($user);
            header('Location: /users');
            exit;
        }

        include __DIR__ . '/../../App/views/user_form.php';
    }

    // Удаление пользователя
    public function delete() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }

        $this->userMapper->delete($id);
        header('Location: /users');
        exit;
    }
}
<?php

declare(strict_types=1);

namespace Otus\AppPDO;

class App
{
    private $userMapper;

    public function __construct()
    {
        $pdo = (new Entry())->getPdo();
        $this->userMapper = new UserMapper($pdo);
    }

    public function run()
    {
        // Пример создания нового пользователя
        $newUser = new User(null, 'John', 'Doe', '123-456-7890', 'john.doe@example.com');
        $newUserId = $this->userMapper->insert($newUser);

        // Пример получения всех пользователей
        $users = $this->userMapper->findAll();
        foreach ($users as $user) {
            echo 'User Name: ' . $user->getName() . "\n";
        }

        // Пример получения пользователя по ID
        $user = $this->userMapper->find($newUserId);
        echo 'User Name: ' . $user->getName() . "\n";

        // Пример обновления пользователя
        $user->setName('Johnathan');
        $this->userMapper->update($user);

        // Пример удаления пользователя
        $this->userMapper->delete($newUserId);
    }
}

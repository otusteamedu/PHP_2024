<?php

declare(strict_types=1);

namespace Otus\AppPDO;

class App
{
    private UserMapper $userMapper;

    public function __construct()
    {
        $pdo = (new Entry())->getPdo();
        $this->userMapper = new UserMapper($pdo);
    }

    /**
     * @return void
     */
    public function run(): void
    {
        // Пример создания нового пользователя
        $newUser = new User(
            null,
            'Alex',
            'Petrov',
            '+79051234567',
            'alex.petrov@example.com'
        );
        $newUserId = $this->userMapper->insert($newUser);

        // Пример получения всех пользователей
        $users = $this->userMapper->findAll();
        foreach ($users as $user) {
            echo 'User Name: ' . $user->getName() . ' ' . $user->getLastName() . "\n";
        }

        // Пример получения пользователя по ID
        $user = $this->userMapper->find($newUserId);
        echo 'User Name: ' . $user->getName() . "\n";

        // Пример обновления пользователя
        $user->setName('Artem');
        $this->userMapper->update($user);

        // Пример удаления пользователя
        $this->userMapper->delete($newUserId);
    }
}

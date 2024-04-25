<?php

namespace AKornienko\Php2024;

use AKornienko\Php2024\DataMapper\UserMapper;
use AKornienko\Php2024\DataMapper\UsersMapper;

class App
{
    public function run(): string
    {
        $config = new Config();
        $dbClient = new DbClient($config);
        $userMapper = new UserMapper($dbClient->getDbConnection());

        return $this->getFormattedResults($userMapper->selectAll());
    }

    private function getFormattedResults(array $users): string
    {
        $formattedResults = '';
        foreach ($users as $user) {
            $formattedResults .= "Имя: {$user->getFirstName()}, Фамилия: {$user->getLastName()}, Дата рождения: {$user->getBirthDate()}\n";
        }
        return $formattedResults;
    }
}

<?php

namespace VSukhov\Hw14\App;

use VSukhov\Hw14\Gate\UserTableGateway;

class App
{
    public function run(): void
    {
        $userTableGateway = new UserTableGateway();
        $users = $userTableGateway->getAllUsers();

        foreach ($users as $user) {
            echo "User ID: {$user['id']}, Name: {$user['name']}" . PHP_EOL;
        }
    }
}

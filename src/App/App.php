<?php

namespace VSukhov\Hw14\App;

use VSukhov\Hw14\Gate\UserTableGateway;

class App
{
    public function run(int $limit = 100, int $offset = 0): array
    {
        $userTableGateway = new UserTableGateway();
        return $userTableGateway->getAllUsers($limit, $offset);
    }
}

<?php

declare(strict_types=1);

namespace AShutov\Hw17;

use AShutov\Hw17\DataMapper\UserMapper;
use AShutov\Hw17\RowGateway\UserFinder;
use AShutov\Hw17\TableGateway\Users;
use PDO;
use PDOException;

class App
{
    public static function run()
    {
        $config = new Config();

        try {
            $pdo = new PDO($config->dsn, $config->user, $config->pass);

            // RowGateway
            $userFinder = new UserFinder($pdo);
            $user = $userFinder->getById(1);
            $user->setName('Александр');
            $user->update();

            // DataMapper
            $mapper = new UserMapper($pdo);
            $user = $mapper->getById(2);
            $user->setName('Максим');
            $mapper->update($user);

            // TableGateway
            $user = new Users($pdo);
            $user->update(3, 'Михаил', 28, 'Директор', 1);

            return $user->getAllUsers();
        } catch (PDOException $e) {
            die('Подключение не удалось: ' . $e->getMessage() . PHP_EOL);
        }
    }
}

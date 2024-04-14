<?php

declare(strict_types=1);

use App\Main\Connection;
use App\Models\User;

require '../vendor/autoload.php';

$connection = new Connection();

/**
 * CREATE
 */
$user1 = new User();
$user1->setFirstName('Иван');
$user1->setLastName('Иванов');
$user1->setEmail('ivanov@mail.ru');

echo 'created' . $user1->create() . PHP_EOL;

$user2 = new User();
$user2->setFirstName('Петр');
$user2->setLastName('Петров');
$user2->setEmail('peter@mail.ru');

echo 'created' . $user2->create() . PHP_EOL;

$user3 = new User();
$user3->setFirstName('Николай');
$user3->setLastName('Николаев');
$user3->setEmail('nikola@mail.ru');

echo 'created' . $user3->create() . PHP_EOL;

/**
 * GET
 */
$user = (new User())->findOneById(1);
echo $user->getId() . PHP_EOL;
echo $user->getEmail() . PHP_EOL;
echo $user->getFirstName() . PHP_EOL;
echo $user->getLastName() . PHP_EOL;
echo $user->getFullName() . PHP_EOL;

$users = (new User())->getAll();
foreach ($users as $user) {
    echo $user->getId() . PHP_EOL;
    echo $user->getEmail() . PHP_EOL;
    echo $user->getFirstName() . PHP_EOL;
    echo $user->getLastName() . PHP_EOL;
    echo $user->getFullName() . PHP_EOL;
}

/**
 * UPDATE
 */
$user->setEmail('new_user_email@mail.ru');
$user->update();
echo ((new User())->findOneById(1))->getEmail() . PHP_EOL;

/**
 * DELETE
 */

$user->delete(1);
echo ((new User())->findOneById(1))?->getId() ?? 'Empty' . PHP_EOL;




<?php

use App\Database;
use App\IdentityMap;
use App\User;
use App\UserMapper;
use Faker\Factory;

require_once __DIR__ . '/../vendor/autoload.php';

$pdo = Database::getConnection();
$identityMap = new IdentityMap();
$userMapper = new UserMapper($pdo, $identityMap);

// Initialize Faker
$faker = Factory::create();

// Insert 500 random users
for ($i = 0; $i < 500; $i++) {
    // Вставка нового пользователя
    $newUser = new User($faker->name, $faker->unique()->email);
    $userMapper->insert($newUser);
}

echo "✅ 500 Random users inserted successfully!" . PHP_EOL;

// Получение всех пользователей
$users = $userMapper->findAll();
foreach ($users as $user) {
    echo "{$user->name} ({$user->email})\n";
}

// Найти пользователя по ID
$user = $userMapper->find(1);
if ($user) {
    echo "User: {$user->name}\n";
}

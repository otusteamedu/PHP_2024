<?php
require_once 'config.php';
require_once 'User.php';
require_once 'UserRegistry.php';


$newUser = new User('John Doe', 'john.doe@example.com');
$newUser->save();
UserRegistry::add($newUser);


$page = 0; 
$limit = 10; 
$users = User::findAll($limit, $page * $limit);

foreach ($users as $user) {
    echo $user->getId() . ": " . $user->getName() . " - " . $user->getEmail() . "\n";
}

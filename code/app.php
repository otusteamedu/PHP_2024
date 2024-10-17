<?php

use AlexAgapitov\OtusComposerProject\App;
use AlexAgapitov\OtusComposerProject\User;

require __DIR__.'/vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'];
    $user = $_ENV['DB_USER'];
    $password = $_ENV['DB_PASS'];
    $Db = new PDO($dsn, $user, $password, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'", PDO::MYSQL_ATTR_LOCAL_INFILE => true]);

    $User = new User();
    $User->connection($Db);
    $User->setFirstName(3)
        ->setLastName(3)
        ->setSecondName(3);
    $User->setId(2);
    $r = $User->update();
    $User->setFirstName(4)
        ->setLastName(4)
        ->setSecondName(4);
    $r = $User->update();
    $User->setFirstName(5);
    $r = $User->update();


} catch (Exception $exception) {
    var_dump($exception->getMessage());
}
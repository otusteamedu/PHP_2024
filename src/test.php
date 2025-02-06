<?php

use SKudashkin\hw16;

$PDO = new PDO('mysql:host=localhost;dbname=otus;port=33060', 'otus', 'otus');

$user = new \RowGateway\User($PDO);
$user->setFirstName('test');
$user->update();


$activeRecordUser = new \ActiveRecord\User($PDO);
$activeRecordUser->setEmail('test@test.com');

$user = (new \DataMapper\UserMapper($PDO))->findById(1);
$user->getFirstName();
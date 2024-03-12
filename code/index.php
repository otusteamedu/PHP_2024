<?php

require __DIR__ . '/vendor/autoload.php';

$user = new \IrinaSYurtaeva\PhpSessionLearn\User();
var_dump($user->authenticate('test', 'test'));
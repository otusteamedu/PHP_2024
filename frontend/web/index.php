<?php

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

$list1 = [1, 2, 4];
$list2 = [1, 3, 4];

print_r((new \hw10\App())->unit($list1, $list2));

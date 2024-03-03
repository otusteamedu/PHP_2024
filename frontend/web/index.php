<?php

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../../';

// Composer
require($dirEnv . 'vendor/autoload.php');

$appService = new \hw6\AppService(new \hw6\EmailValidator());
echo $appService->validate();

<?php

use Dotenv\Dotenv;
use helpers\Brackets;
use services\{BracketsService, SessionService, HostService};

define("BASE_PATH", __DIR__);

$dirEnv = __DIR__ . '/../';

// Composer
require($dirEnv . 'vendor/autoload.php');
require($dirEnv . 'autoload.php');

$dotenv = Dotenv::createUnsafeImmutable($dirEnv);
$dotenv->load();

$mainservice = new \services\MainService(
    new BracketsService(
        new Brackets()
    ),
    new SessionService,
    new HostService
);

return $mainservice->process();

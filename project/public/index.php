<?php

declare(strict_types=1);

require dirname(__DIR__) . '/vendor/autoload.php';

use SFadeev\HW4\Kernel;
use SFadeev\HW4\Request;

$kernel = new Kernel();
$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();

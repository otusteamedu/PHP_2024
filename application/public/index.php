<?php

use Den\Hw5\App;
use Den\Hw5\Http\Request;

require '../vendor/autoload.php';

$request = Request::createFromGlobals();
$app = new App($request);
echo $app->run();

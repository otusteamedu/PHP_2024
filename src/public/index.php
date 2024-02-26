<?php

declare(strict_types=1);

require_once "../../vendor/autoload.php";

use RailMukhametshin\Hw\Actions\StringValidatorAction;
use RailMukhametshin\Hw\Requests\StringRequest;

$request = new StringRequest();
$action = new StringValidatorAction();
$action->run($request);

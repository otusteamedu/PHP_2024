<?php

declare(strict_types=1);

require_once "../../vendor/autoload.php";

use RailMukhametshin\Hw\Actions\StringValidatorAction;

$action = new StringValidatorAction();
echo $action->run();

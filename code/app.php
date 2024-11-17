<?php

declare(strict_types=1);

require_once __DIR__ . "/src/vendor/autoload.php";

use Kyberlox\App\App as App;

$app = new App();
$app->run($argv);

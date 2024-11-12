<?php

declare(strict_types=1);

require "src/vendor/autoload.php";

use Kyberlox\App\App as App;

$app = new App();
$app->run($argv);

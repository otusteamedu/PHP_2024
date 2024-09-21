<?php

declare(strict_types=1);

require_once dirname(__DIR__) . '/app/vendor/autoload.php';

use App\App;

$app = (new App());
$app->run($argv);

<?php

declare(strict_types=1);

use Viking311\DbPattern\Application\Application;

require "./vendor/autoload.php";

$app = new Application();

echo $app->run()->render();

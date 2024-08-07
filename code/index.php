<?php

declare(strict_types=1);

use Viking311\Analytics\Application\Application;

require 'vendor/autoload.php';

$app = new Application();

$app->run()->render();
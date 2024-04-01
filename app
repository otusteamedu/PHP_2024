#!/usr/bin/env php

<?php

use Pozys\OtusShop\App;

require_once './vendor/autoload.php';

try {
  $app = new App();
  $app->run();
} catch (Exception $e) {
  echo $e->getMessage() . PHP_EOL;
}

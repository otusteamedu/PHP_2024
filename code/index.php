<?php

require "./vendor/autoload.php";

$app = new App\App();
echo $app->run()->render();

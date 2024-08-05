<?php

require __DIR__ . '/vendor/autoload.php';

use Ekonyaeva\Otus\App\App;

$app = new App();
$response = $app->run();

http_response_code($response['status']);
echo $response['message'];

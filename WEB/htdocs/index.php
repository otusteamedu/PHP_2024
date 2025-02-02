<?php

require __DIR__ . '/autoload.php';

use app\Controllers\MainController;
use app\Services\ValidationService; // Corrected namespace

$validationService = new ValidationService();
$controller = new MainController($validationService);

$response = $controller->handleRequest();

http_response_code($response['code'] ?? 200);
echo $response['message'];

?>
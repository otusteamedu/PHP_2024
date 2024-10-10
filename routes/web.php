<?php

use App\Controllers\RequestController;

$router->get('/', [RequestController::class, 'showForm']);
$router->post('/submit', [RequestController::class, 'submitRequest']);

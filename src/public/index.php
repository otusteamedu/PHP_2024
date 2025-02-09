<?php

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/
require __DIR__ . '/../vendor/autoload.php';

use Application\Services\TheatreService;
use Domain\Entities\Theatre;
use Infrastructure\Http\Controllers\TheatreController;
use Infrastructure\Persistence\TheatreRepository;

$theatreRepository = new TheatreRepository();
$theatreService = new TheatreService($theatreRepository);
$theatreController = new TheatreController($theatreService);

// Пример маршрутизации (можно использовать любой роутер)
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/theatres' && $requestMethod === 'GET') {
    $response = $theatreController->index();
    echo '<pre>';
    print($response);
    echo '</pre>';
} elseif (preg_match('/\/theatres\/(\d+)/', $requestUri, $matches) && $requestMethod === 'GET') {
    $response = $theatreController->show((int)$matches[1]);
    echo '<pre>';
    print($response);
    echo '</pre>';
} elseif ($requestUri === '/theatres' && $requestMethod === 'POST') {
    $theatre = new Theatre();
    // Заполнение $theatre данными из запроса
    return $theatreController->store($theatre);
} elseif (preg_match('/\/theatres\/(\d+)/', $requestUri, $matches) && $requestMethod === 'PUT') {
    $theatre = new Theatre();
    // Заполнение $theatre данными из запроса
    return $theatreController->update($theatre);
} elseif (preg_match('/\/theatres\/(\d+)/', $requestUri, $matches) && $requestMethod === 'DELETE') {
    return $theatreController->destroy((int)$matches[1]);
}

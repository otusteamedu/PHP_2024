<?php

// Подключение автозагрузки классов (Composer)
require_once __DIR__ . '/../vendor/autoload.php';

// Инициализация роутера
require_once __DIR__ . '/../app/core/Router.php';
use App\Core\Router;

// Создание экземпляра роутера
$router = new Router();

// Определение маршрутов
$router->addRoute('users', 'UserController', 'index');
$router->addRoute('user/create', 'UserController', 'create');
$router->addRoute('user/edit/(\d+)', 'UserController', 'edit');
$router->addRoute('user/delete/(\d+)', 'UserController', 'delete');

// Получение контроллера и действия
$controllerName = $router->getController();
$action = $router->getAction();

// Вызов контроллера
$controllerClass = "App\\Controllers\\$controllerName";
if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "Метод не найден.";
    }
} else {
    echo "Контроллер не найден.";
}
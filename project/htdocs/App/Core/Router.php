<?php

namespace App\Core;

class Router {
    private $routes = [];
    private $controllerName;
    private $action;
    public function __construct() {
        $this->parseRequest();
    }

    // Добавление маршрута
    public function addRoute($route, $controller, $action) {
        $this->routes[$route] = [
            'controller' => $controller,
            'action' => $action
        ];
    }

    // Разбор входящего запроса
    private function parseRequest() {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestUri = ltrim($requestUri, '/'); // Удаляем начальный слеш

        foreach ($this->routes as $route => $data) {
            if (preg_match("#^$route$#", $requestUri, $matches)) {
                $this->controllerName = $data['controller'];
                $this->action = $data['action'];

                // Передача параметров из URL в GET
                array_shift($matches); // Удаляем полное совпадение
                $_GET = array_merge($_GET, array_slice($matches, 1));

                return;
            }
        }

        // Если маршрут не найден, показываем ошибку 404
        $this->controllerName = 'ErrorController';
        $this->action = 'notFound';
    }

    // Получение контроллера и действия
    public function getController() {
        return $this->controllerName;
    }

    public function getAction() {
        return $this->action;
    }
}
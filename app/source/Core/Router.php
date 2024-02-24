<?php

namespace Pavelsergeevich\Hw6\Core;

use Pavelsergeevich\Hw6\Config;

class Router
{
    public array $routes = [];
    public string $currentRoute;
    public array $currentParams;
    public function __construct()
    {
        $this->load();
    }

    private function load(): void
    {
        $routesConfig = Config\Routes::getRoutes();
        foreach ($routesConfig as $route => $params) {
            $this->add($route, $params);
        }
    }
    public function add(string $route, array $params) {
        $routeRegular = '#^' . $route . '$#';
        $this->routes[$routeRegular] = $params;
    }

    public function match(): bool
    {
        $currentUrl = trim($_SERVER['REQUEST_URI'], '/');
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $currentUrl, $matches)) {
                $this->currentRoute = $route;
                $this->currentParams = $params;
                return true;
            }
        }
        return false;
    }


    public function run(): void
    {
        try {
            if ($this->match()) {
                $controllerClass = Controller::CONTROLLERS_NAMESPACE . $this->currentParams['controller'] . Controller::CONTROLLERS_ENDING;
                $actionMethod = $this->currentParams['action'] . Controller::ACTION_ENDING;
                if (!(class_exists($controllerClass) && method_exists($controllerClass, $actionMethod))) {
                    throw new \Exception('Не найден класс или метод контроллера: ' . $controllerClass . '::' . $actionMethod, 500);
                }

                $controller = new $controllerClass($this->currentParams);
                $controller->$actionMethod();

            } else {
                throw new \Exception('Не обнаружена страница - 404 todo', 404);
            }
        } catch (\Throwable $exception) {
            View::errorCode($exception); //todo: я думаю, что это должен быть метод контроллера, архитектурно некорректно из роутера во вью лезть
        }
    }
}
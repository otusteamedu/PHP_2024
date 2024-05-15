<?php

declare(strict_types=1);

namespace App\Infrastructure\Main;

use App\Infrastructure\Traits\SingletonTrait;
use Exception;

final class App
{
    use SingletonTrait;

    /**
     * @throws Exception
     */
    public function run(Request $request): mixed
    {
        $controllerName = $request->getController() or throw new \Exception('controller not found');

        $params = $request->getAll();
        $actionName = $request->getAction();

        $controllerClass = 'App\\Infrastructure\\Http\\Controller\\' . ucfirst($controllerName) . "Controller";

        class_exists($controllerClass) or throw new \Exception('class not found');

        $controller = new $controllerClass();
        $refObject = new \ReflectionClass($controller);
        $refProperty = $refObject->getProperty('request');
        $refProperty->setValue($controller, $request);

        return $controller->runAction($actionName, $params);
    }
}

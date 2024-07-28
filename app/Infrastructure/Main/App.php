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

        $controllerClass = 'App\\Infrastructure\\Http\\Controller\\Api\\v1\\'
            . ucfirst(dashesToCamelCase($controllerName))
            . "Controller";


        class_exists($controllerClass) or throw new \Exception('class not found');

        $services = [];

        $classConstruct = new \ReflectionMethod($controllerClass, '__construct');

        if (count($classConstruct->getParameters())) {
            $servicesPath = config('service_namespace');

            foreach ($classConstruct->getParameters() as $service) {
                $serviceClass = $servicesPath . ucfirst($service->getName());

                if (class_exists($serviceClass)) {
                    $services[] = new $serviceClass();
                }
            }
        }

        $controller = new $controllerClass(...$services);
        $refObject = new \ReflectionClass($controller);
        $refProperty = $refObject->getProperty('request');
        $refProperty->setValue($controller, $request);

        return $controller->runAction($actionName, $params);
    }
}

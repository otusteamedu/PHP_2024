<?php
declare(strict_types=1);

namespace App\Infrastructure\Components;

class Router
{
    private array $routes;

    public function __construct(){
        $routsPath = ROOT .'/config/routes.php';
        $this->routes = include($routsPath);
    }

    public function getURL()
    {
        if(!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'],'/');
        }
    }

    public function run():void
    {
        $url = $this->getURL();

        if(!isset($url)) $url='';

        foreach ($this->routes as $urlPattern => $route) {

            if(preg_match("~$urlPattern~",$url)){
                $internalRoute = preg_replace("~$urlPattern~", $route, $url);

                $segments = explode('/',$internalRoute);

                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;

                $controllerFile = ROOT.'/src/Infrastructure/Controllers/'.$controllerName.'.php';
                if(file_exists($controllerFile)){
                    include_once($controllerFile);

                }

                $controllerName = "App\Infrastructure\Controllers\\".$controllerName;
                $controllerObject = new $controllerName();

                if(!method_exists($controllerObject,$actionName)) break;
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                // Если метод контроллера успешно вызван, завершаем работу роутера
                if ($result != null) {
                    break;
                }

            }


        }

    }

}
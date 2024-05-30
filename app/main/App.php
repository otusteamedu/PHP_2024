<?php


namespace App\main;


use App\exceptions\AddressNotFoundException;
use App\services\renders\TwigRender;
use App\traits\TSingleton;


class App
{
    use TSingleton;

    public static function call(): App
    {
        return static::getInstance();
    }

    public function run()
    {
        $request = new \App\services\Request();
        $controllerName = $request->getControllerName() ?: 'good';

        if (!empty($request->session("user"))) {
          $controllerName = $request->getControllerName() ?: 'userAuth';
      }


        if ($request->session("role") == 1) {
            $controllerName = $request->getControllerName() ?: 'userAdmin';
        }




        $actionName = $request->getActionName();

        new \Twig\Loader\FilesystemLoader();

        $ControllerClass = 'App\\controllers\\' . ucfirst($controllerName) . 'Controller';

    
        try {
            if (!class_exists($ControllerClass)) {
                throw new AddressNotFoundException();
            }

            $controller = new $ControllerClass(new TwigRender(), $request);
            echo $controller->run($actionName);

        } catch (AddressNotFoundException $e) {
            echo (new TwigRender())->render('error');

        }
    }

}
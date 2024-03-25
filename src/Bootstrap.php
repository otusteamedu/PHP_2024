<?php

declare(strict_types=1);

namespace hw14;

class Bootstrap
{
    public function getMethod()
    {
        $router = new Router();

        $router->addRoute('GET', '/bulk', function () {
            return MethodDictionary::BULK;
        });

        $router->addRoute('GET', '/create-index', function () {
            return MethodDictionary::CREATE_INDEX;
        });

        $router->addRoute('GET', '/exists-index', function () {
            return MethodDictionary::EXISTS_INDEX;
        });

        $router->addRoute('GET', '/test', function () {
            return MethodDictionary::TEST;
        });

        return $router->matchRoute();
    }
}

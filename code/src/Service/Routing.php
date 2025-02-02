<?php

namespace DudkinIv\TestPackage\Service;

use DudkinIv\TestPackage\Controller\IndexController;

class Routing
{
    protected IndexController $controller;

    public function __construct()
    {
        $this->controller = new IndexController();
    }

    public function handle(): string
    {
        $method = $this->getHttpMethod();

        return $this->controller->{$method}();
    }

    protected function getHttpMethod(): string
    {
        $method = match ($_SERVER['REQUEST_METHOD']) {
            'POST' => 'post',
            'GET' => 'get',
            default => '',
        };

        return $method . 'Action';
    }
}

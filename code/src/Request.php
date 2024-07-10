<?php

namespace Naimushina\Webservers;

class Request
{

    /**
     * @var mixed
     */
    public $method;
    /**
     * @var array|array[]
     */
    public $params;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->params = [
            'get' => $_GET,
            'post' => $_POST,
        ];
    }
}

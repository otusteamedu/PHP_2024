<?php
declare(strict_types=1);

namespace Naimushina\Webservers;

use Exception;

class App
{
    /**
     * @var Request
     */
    public $request;
    /**
     * @var Response
     */
    public $response;

    public function __construct(){
        $this->request = new Request();
        $this->response = new Response();
    }

    /**
     * @throws Exception
     */
    public function run(){
        $controller = new FrontController($this->request, $this->response);
        if($this->request->method === 'GET'){
           return  $controller->show();
        }
        if($this->request->method === 'POST'){
            $validator = new StringValidator();
            return $controller->index($validator);
        }
        throw new Exception('Method not allowed');
    }

}

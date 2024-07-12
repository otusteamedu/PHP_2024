<?php

declare(strict_types=1);

namespace Naimushina\Webservers;

use Exception;
use Predis\Client;

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

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->startSession();

    }

    /**
     * @throws Exception
     */
    public function run()
    {
        $controller = new FrontController($this->request, $this->response);
        if ($this->request->method === 'GET') {
            return $controller->show();
        }
        if ($this->request->method === 'POST') {
            $validator = new StringValidator();
            return $controller->index($validator);
        }
        throw new Exception('Method not allowed');
    }

    /**
     * Устанавливаем Redis для обработки сессий
     * @return void
     */
    private function startSession()
    {
        $host = getenv('SESSION_HOST');
        $port = getenv('SESSION_PORT');
        $scheme= getenv('SESSION_SCHEME');

         $db = new Client(
             [
                 'scheme' => $scheme,
                 'host' => $host,
                 'port' => $port,
                 'password' => ''
             ]
         );
        $path = "$scheme://$host:$port";

        $handler = new RedisSessionHandler($db);
        session_set_save_handler($handler);
        session_start([
            'save_handler' => getenv('SESSION_DRIVER'),
            'save_path' => $path
        ]);
    }
}

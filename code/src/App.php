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

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
        $app_ip = '127.0.0.1';
        session_start([
            'save_path' => http_build_query([
                'seed' => [
                    $app_ip . ':6381',
                    $app_ip . ':6382',
                    $app_ip . ':6383',
                    $app_ip . ':6384',
                    $app_ip . ':6385',
                    $app_ip . ':6386',
                ],
                'timeout' => 2,
                'read_timeout' => 10,
                'failover' => 'error',
            ]),
        ]);
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
}

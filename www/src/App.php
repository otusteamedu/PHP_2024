<?php

namespace Ahor\Hw19;

use Ahor\Hw19\request\Request;
use Ahor\Hw19\response\Response;
use Ahor\Hw19\handler\RequestHandler;
use Ahor\Hw19\rabbit\Config;
use Ahor\Hw19\rabbit\ConnectFactory;
use Ahor\Hw19\rabbit\Producer;
use Ahor\Hw19\request\Form;

class App
{
    public function run(): void
    {
        $request = new Request();
        $value = $request->phpInput();
        $connect = ConnectFactory::create(Config::build());
        $message = (new RequestHandler(new Producer($connect)))->handle(new Form(
            empty($value) ? [] : json_decode($value, true, 512, JSON_THROW_ON_ERROR)
        ));
        $response = new Response();
        $response->send($message);
    }
}

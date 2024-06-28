<?php

namespace TBublikova\Php2024;

class App
{
    public function run()
    {
        $requestHandler = new RequestHandler();
        $response = $requestHandler->handle($_POST);

        http_response_code($response['code']);

        print_r($response['msg'] . "\n");
    }
}

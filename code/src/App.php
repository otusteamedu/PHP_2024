<?php

namespace TBublikova\Php2024;

class App
{
    public function run(): string
    {
        $response = (new RequestHandler())->handle($_POST);
        http_response_code($response['code']);
        return $response['msg'];
    }
}

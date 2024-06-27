<?php

namespace TBublikova\Php2024;

class App
{
    public function run()
    {
        $requestHandler = new RequestHandler();
        $response = $requestHandler->handle($_POST);

        if (strpos($response, '200 OK') !== false) {
            http_response_code(200);
        } else {
            http_response_code(400);
        }

        echo $response;
    }
}

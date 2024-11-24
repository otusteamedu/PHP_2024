<?php

declare(strict_types=1);

namespace AnatolyShilyaev\App;

class App
{
    public function run()
    {
        $result = (new Checker())->check($_POST['string']);

        if ($result) {
            header("HTTP/1.1 200 OK", true, 200);
            return '200 Ok!';
        } else {
            header("HTTP/1.1 400 BAD REQUEST", true, 400);
            return '400 Bad request!';
        }
    }
}

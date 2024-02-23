<?php

namespace Kagirova\Brackets;

class App
{
    public function run(): void
    {
        $request = new Request();
        if ($request->validateString()) {
            echo 'ok';
        } else {
            http_response_code(400);
            print_r("Invalid brackets sequence\n");
        }
    }
}

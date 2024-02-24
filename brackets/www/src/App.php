<?php

namespace Kagirova\Brackets;

class App
{
    public function run(): string
    {
        try {
            $request = new Request();
            $request->validateString();
            return 'OK';
        } 
        catch (\Throwable $e) {
            http_response_code(400);
            return $e->getMessage();
        }
    }
}

<?php

namespace App;

class StatusResponseService
{
    public function __construct()
    {
    }
    public function setResponse200(): void
    {
        http_response_code(HttpStatus::OK);
    }
    public function setResponse400(): void
    {
        http_response_code(HttpStatus::BAD_REQUEST);
    }
}

<?php

namespace Ahor\Hw19\request;

class Request
{
    public function phpInput(): false|string
    {
        return file_get_contents('php://input');
    }
}

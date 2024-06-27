<?php

namespace TBublikova\Php2024;

class RequestHandler
{
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function handle(array $postData): string
    {
        if (!isset($postData['string'])) {
            return '400 Bad Request: Missing string parameter';
        }

        $string = $postData['string'];

        if ($this->validator->validate($string)) {
            return '200 OK: Everything is fine';
        }

        return '400 Bad Request: Invalid string';
    }
}

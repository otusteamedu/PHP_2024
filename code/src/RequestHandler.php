<?php

namespace TBublikova\Php2024;

class RequestHandler
{
    private $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function handle(array $postData): array
    {
        if (!isset($postData['string'])) {
            return ['code' => 400, 'msg' => 'Bad Request: Missing string parameter'];
        }

        $string = $postData['string'];

        if ($this->validator->validate($string)) {
            return ['code' => 200, 'msg' => 'OK: Everything is fine'];
        }

        return ['code' => 400, 'msg' => 'Bad Request: Invalid string'];
    }
}

<?php

declare(strict_types=1);

namespace App;

class Application
{
    protected Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function run()
    {
        if (empty($_POST)) return;

        $request = trim($_POST['string']);

        if (empty($request)) {
            throw new \Exception('Передан пустой запрос');
        }

        if (!$this->validator->sequenceParentheses($request)) {
            http_response_code(400);
            throw new IncorrectParenthesesException('Неверная последовательность скобок');
        }

        http_response_code(200);
        echo "Последовательность скобок верна";
    }
}

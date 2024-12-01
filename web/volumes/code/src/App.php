<?php

declare(strict_types=1);

namespace RShevtsov\Hw5;

class App
{
    private Response $response;
    private Validator $validator;

    public function __construct()
    {
        $this->response = new Response();
        $this->validator = new Validator();
    }

    public function run(array $array = []): void
    {
        if (empty($array)) {
            $this->response->setError("Массив email адресов пуст");
            return;
        }

        foreach ($array as $email) {
            if (trim($email) == '') {
                $this->response->setError("пустая строка<br>");
            }
            if ($this->validator->check(trim($email))) {
                $this->response->setSuccess($email . " корректный email<br>");
            } else {
                $this->response->setError($email . " некорректный email<br>");
            }
        }
    }
}

<?php

declare(strict_types=1);

namespace App;

use Exception;

class Application
{
    protected Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function run()
    {
        $emailAddresses = $_POST['emailAddresses'] ?? [];

        if (!$this->validator->isEmails($emailAddresses)) {
            http_response_code(400);
            throw new Exception("Почтовые адреса не прошли проверку");
        }

        http_response_code(200);
        echo 'Почтовые адреса прошли проверку';
    }
}

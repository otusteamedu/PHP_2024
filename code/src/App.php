<?php

declare(strict_types=1);

namespace Dsmolyaninov\Hw4;

use Dsmolyaninov\Hw4\Validator\BracketsValidator;

class App
{
    public function run(): string
    {
        $string = $_POST['string'] ?? '';

        if (!empty($string) && BracketsValidator::isBracketsValid($string)) {
            http_response_code(200);
            header('Content-Type: text/plain; charset=utf-8');
            return "Строка корректна.";
        } else {
            http_response_code(400);
            header('Content-Type: text/plain; charset=utf-8');
            return "Строка некорректна.";
        }
    }
}

<?php

declare(strict_types=1);

namespace Src;

class App
{
    public function run(): void
    {
        if (!empty($_POST['string'])) {
            if ($this->isStringValid($_POST['string'])) {
                http_response_code(200);
                echo 'String is valid!';
            } else {
                $this->throwErrorMessageCode('String is not valid!');
            }
        } else {
            $this->throwErrorMessageCode('String is empty!');
        }
    }

    private function isStringValid(string $string): bool
    {
        $count = 0;

        for ($i = 0; $i < strlen($string); $i++) {
            if ($string[$i] === '(') {
                $count++;
            } else if ($string[$i] === ')') {
                $count--;
            }

            if ($count < 0) {
                return false;
            }
        }

        return $count === 0;
    }

    private function throwErrorMessageCode(string $msg): void
    {
        http_response_code(400);
        throw new Exception($msg);
    }
}

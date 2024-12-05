<?php

declare(strict_types=1);

namespace Otus\App;

use Exception;

class Validation
{
    private $methods = ['bracket', 'empty'];
    public function check(string $input): void
    {
        foreach ($this->methods as $method) {
            if ($this->$method($input)) {
                http_response_code(400);
                throw new Exception("{$method} error");
            }
        }
        http_response_code(200);
    }
    public function bracket(string $input): bool
    {
        $input = preg_replace('/[^(|)]/', "", $input);
        $repl = str_replace([")"], ["(r"], $input);
        $result = preg_replace('/([(])(?R)*\1r/', "", $repl);
        return mb_strlen($result) != 0;
    }

    public function empty(string $input): bool
    {
        return empty($input);
    }
}

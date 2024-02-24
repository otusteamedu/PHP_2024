<?php

namespace Kagirova\Brackets;

class Request
{
    public function validateString(): void
    {
        if (!$this->validateMethod()) {
            throw new \Exception("Method has to be POST");
        }
        if (!$this->validateValueName('string')) {
            throw new \Exception("Argument 'string' expected");
        }
        $str = $_POST['string'];
        if (!strlen($str)) {
            throw new \Exception("String must not be empty");
        }
        if (preg_match('/^[()]+$/', $str)) {
            $count = 0;
            foreach (str_split($str) as $char) {
                if ($char == '(') {
                    $count++;
                } else {
                    $count--;
                }
                if ($count < 0) {
                    throw new \Exception("String is invalid");
                }
            }
            if ($count != 0) {
                throw new \Exception("String is invalid");
            }
        } else {
            throw new \Exception("String must contain only ( and )");
        }
    }

    public function validateMethod()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function validateValueName($value_name)
    {
        return isset($_POST[$value_name]);
    }
}

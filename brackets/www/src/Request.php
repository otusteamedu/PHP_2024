<?php

namespace Kagirova\Brackets;

class Request
{
    public function validateString(): bool
    {
        if ($this->validateMethod() && $this->validateValueName('string')) {
            $str = $_REQUEST['string'];
            if (!strlen($str)) {
                return false;
            }
            if (preg_match('/[()]*/', $str)) {
                $count = 0;
                foreach (str_split($str) as $char) {
                    if ($char == '(') {
                        $count++;
                    } else {
                        $count--;
                    }
                    if ($count < 0) {
                        return false;
                    }
                }
                if ($count == 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        return false;
    }

    public function validateMethod()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function validateValueName($value_name)
    {
        return isset($_REQUEST[$value_name]);
    }
}

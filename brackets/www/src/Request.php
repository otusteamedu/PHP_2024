<?php


namespace Kagirova\Brackets;


class Request
{
    public function validate_string(): bool
    {
        if ($this->validate_method() && $this->validate_value_name('string')) {
            $str = $_REQUEST['string'];
            if (!strlen($str)){
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

    public function validate_method(){
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    public function validate_value_name($value_name){
        return isset($_REQUEST[$value_name]);
    }
}
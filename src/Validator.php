<?php

namespace ValidatorBrackets;

include __DIR__ . "/Response.php";

class Validator
{
    public static function validate($string)
    {
        $string = trim($string);

        if (!strlen($string)) {
            Response::answer('Пустая строка', true);
        }

        if (!preg_match("/^[)(]+$/u", $string)) {
            Response::answer('Обнаружены недопустимые символы, допустимы только ( и )', true);
        }

        $length = strlen($string);

        $counter = 0;
        for ($i = 0; $i < $length; $i++) {
            $chr = substr($string, $i, 1);

            if ($i == 0) {
                if ($chr != '(') {
                    Response::answer('Некоректная строка, должна начинаться с (', true);
                }
            }

            if ($chr == '(') {
                $counter++;
            } elseif ($chr == ')') {
                $counter--;
            }
            
            if ($counter < 0) {
                Response::answer('Некорректная строка - скобок ) больше чем открываюших', true);
                exit();
            }
        }

        if ($counter != 0) {
            Response::answer('Некорректная строка - скобок ( больше чем закрывающих', true);
        } else {
            Response::answer('Все ОК!');
        }
    }
}

<?php

namespace Ekonyaeva\Otus\Services;

class Validator
{
    public function validate($string)
    {
        if (empty($string)) {
            return [
                'status' => 400,
                'message' => '400 Bad Request: строка пуста'
            ];
        }

        $stack = [];
        foreach (str_split($string) as $char) {
            if ($char === '(') {
                array_push($stack, $char);
            } elseif ($char === ')') {
                if (empty($stack)) {
                    return [
                        'status' => 400,
                        'message' => '400 Bad Request: некорректное количество скобок'
                    ];
                }
                array_pop($stack);
            }
        }

        if (empty($stack)) {
            return [
                'status' => 200,
                'message' => '200 OK: строка корректна'
            ];
        } else {
            return [
                'status' => 400,
                'message' => '400 Bad Request: некорректная строка'
            ];
        }
    }
}
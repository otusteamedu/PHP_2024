<?php

namespace Naimushina\Webservers;

use Cassandra\Exception\ValidationException;
use Exception;

class StringValidator implements IValidator
{
    /**
     * Проверяем параметр string
     * На не пустоту
     * На корректность кол-ва открытых и закрытых скобок
     * @throws Exception
     */
    public function validate(Request $request)
    {
        $string = $request->params['post']['string'];
        if (!$string) {
            throw new Exception('Строка не может быть пустой');
        }
        if (!$this->checkParenthesis($string)) {
            throw new Exception('Некорректно кол-во открытых и закрытых скобок');
        }
    }

    /**
     * Проверяем корректность открытых и закрытых скобок
     * @param $string
     * @return bool
     */
    public function checkParenthesis($string): bool
    {
        $string = str_split($string);
        $stack = [];
        foreach ($string as $key => $value) {
            switch ($value) {
                case '(':
                    $stack[] = 0;
                    break;
                case ')':
                    if (array_pop($stack) !== 0) {
                        return false;
                    }
                    break;
            }
        }
        return (empty($stack));
    }
}

<?php
declare(strict_types=1);

namespace App\Services;

use App\Exceptions\StringValidException;

class StringService
{
    public string $string;

    public function __construct(string $string)
    {
        $this->string = trim($string);
    }

    public function validete()
    {
        if (empty($this->string)) {
            return $this->getValidateError('empty string!');
        } elseif((!str_starts_with($this->string, "(")) || (!str_ends_with($this->string, ")"))) {
            return $this->getValidateError('incorrect start or end of string!');
        } elseif (mb_substr_count($this->string, "(") !== mb_substr_count($this->string, ")")) {
            return $this->getValidateError('number of open parentheses does not match with closed parentheses!');
        }
        return "'" . $this->string . "'" . " is a valid string!";
    }

    public function getValidateError($message)
    {
        throw new StringValidException($message);
    }
}
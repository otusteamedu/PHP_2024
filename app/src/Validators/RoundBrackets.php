<?php


namespace App\Validators;


final class RoundBrackets
{
    private string $_pattern = '/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/';

    public function validate(string $string = ''): bool
    {
        return preg_match($this->_pattern,$string);
    }

}
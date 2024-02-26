<?php

namespace App;

class StringBracketValidator
{
    const OPEN = "(";
    const CLOSED = ")";

    protected $errorMessage = "";

    protected $validationValue;


    public function __construct($value)
    {
        $this->validationValue = $value;
    }

    public function validate(): bool
    {
        if (!$this->validateIsNotEmpty()) {
            return false;
        }


        if (!$this->validateBrackets()) {
            return false;
        }

        return true;
    }

    protected function validateIsNotEmpty(): bool
    {
        if (empty($this->validationValue)) {
            $this->errorMessage = "Передана пустая строка";
            return false;
        }
        return true;
    }


    protected function validateBrackets(): bool
    {
        $validateSumm = 0;
        $chars = str_split($this->validationValue);

        foreach ($chars as $char) {
            if ($char == self::OPEN) {
                $validateSumm++;
            }

            if ($char == self::CLOSED) {
                $validateSumm--;
            }

            if ($validateSumm < 0) {
                break;
            }
        }

        if ($validateSumm != 0) {
            $this->errorMessage = "Скобки в строке расставлены не верно.";
            return false;
        }

        return true;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}

<?php

namespace src\Classes\Validate;

class Brackets
{
    protected string $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @throws \Exception
     */
    public function validate(): void
    {
        $this->checkBracketCount();
    }

    /**
     * @throws \Exception
     */
    protected function checkBracketCount(): void
    {
        $arrayOfBrackets = str_split($this->string);

        $countOfOpenBrackets = 0;
        if ($arrayOfBrackets[0] !== '(' && end($arrayOfBrackets) !== ')') {
            throw new \Exception('Wrong string');
        }

        foreach ($arrayOfBrackets as $bracket) {
            if ($bracket !== '(' && $bracket !== ')') {
                throw new \Exception('Its not bracket');
            }

            if ($bracket === '(') {
                $countOfOpenBrackets++;
            } else {
                $countOfOpenBrackets--;
            }

            if ($countOfOpenBrackets < 0) {
                throw new \Exception('Closed brackets more than opened');
            }
        }

        if ($countOfOpenBrackets !== 0) {
            throw new \Exception('Brackets count is wrong');
        }
    }
}

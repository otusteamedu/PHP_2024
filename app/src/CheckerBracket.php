<?php

namespace Dsergei\Hw4;

class CheckerBracket implements ICheckerInterface
{
    /**
     * @param string $string
     * @return void
     * @throws \Exception
     */
    public function check(string $string): void
    {
        if(!preg_match('/^[()]+$/', $string)) {
            throw new \Exception('Access only brackets "(" and ")"');
        }

        $this->checkOpenClose($string);
    }

    /**
     * @param string $string
     * @return void
     * @throws \Exception
     */
    private function checkOpenClose(string $string): void
    {
        $openCountBracket = 0;
        $closeCountBracket = 0;

        foreach (str_split($string) as $char) {
            if ($char === "(") {
                $openCountBracket++;
            } elseif ($char === ")") {
                $closeCountBracket++;
            }
        }

        if($openCountBracket !== $closeCountBracket) {
            throw new \Exception('No valid count breackets');
        }
    }
}
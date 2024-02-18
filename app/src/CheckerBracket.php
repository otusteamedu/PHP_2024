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
        if (!preg_match('/^[()]+$/', $string)) {
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
        $stackBracket = [];
        $isValid = true;
        foreach (str_split($string) as $char) {
            if ($char === "(") {
                array_push($stackBracket, $char);
            } else {
                if (empty($stackBracket) || array_pop($stackBracket) !== "(") {
                    $isValid = false;
                    break;
                }
            }
        }

        if (!$isValid) {
            throw new \Exception('No valid brackets');
        }
    }
}

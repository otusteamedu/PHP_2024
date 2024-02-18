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
        foreach (str_split($string) as $char) {
            if ($char === "(") {
                array_push($stackBracket, $char);
            } else {
                if (array_pop($stackBracket) !== "(") {
                    break;
                }

                if (empty($stackBracket)) {
                    $stackBracket[] = null;
                    break;
                }
            }
        }

        if (count($stackBracket) > 0) {
            throw new \Exception('No valid brackets');
        }
    }
}

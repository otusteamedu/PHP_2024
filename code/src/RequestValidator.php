<?php

namespace Otus\Hw4;

class RequestValidator
{
    /**
     * @param $postString
     * @return bool
     */
    public function validate($postString): bool
    {
        $bracketsCounter = 0;
        foreach (str_split($postString) as $char) {
            if ($char == '(') {
                $bracketsCounter++;
            } elseif ($char == ')') {
                if ($bracketsCounter == 0) {
                    return false;
                }
                $bracketsCounter--;
            }
        }

        return $bracketsCounter === 0;
    }
}

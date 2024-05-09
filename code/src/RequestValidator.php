<?php
namespace Otus\Hw4;

class RequestValidator
{

    /**
     * @param $postString
     * @return int
     */
    public function validate($postString): int
    {
        $bracketsCounter = 0;
        foreach (str_split($postString) as $char) {
            if ($char == '(') {
                $bracketsCounter++;
            } elseif ($char == ')') {
                if ($bracketsCounter != 0) {
                    $bracketsCounter--;
                }
            }
        }
        
        return $bracketsCounter;
    }
}

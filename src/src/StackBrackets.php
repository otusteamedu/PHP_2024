<?php

namespace TimurShakirov\Hw4;

class StackBrackets {
    private $brackets;
    private $pattern;
    private $stack;
 
    public function __construct($str, $pcre = '()')
    {
        $this->brackets = preg_replace("~[^$pcre]~", '', $str);
        $this->pattern = substr($pcre, 0, 1);
        $this->stack = [];
    }
 
    public function check()
    {
        for ($i = 0, $all = strlen($this->brackets); $i < $all; $i++) {
            $element = $this->brackets[$i];
            if ($element == $this->pattern) {
                $this->addBracket($element);
            } else {
                $current = $this->delBracket();
                if ($current != $this->pattern) {
                    return false;
                }
            }
        }
 
        return ($this->allBrackets() <= 0);
    }
 
    private function addBracket($item) {
        array_unshift($this->stack, $item);
    }
 
    private function delBracket() {
        return empty($this->stack) ? false : array_shift($this->stack);
    }
 
    private function allBrackets() {
        return count($this->stack);
    }
}

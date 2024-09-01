<?php

namespace HW4;

class StringHandler
{
    public $protocol = 'HTTP/1.1';
    public $code = 200;
    public $message = 'It`s OK';

    public function run(string $string): void
    {
        if (
            $this->isEmpty($string)
            || !$this->isCorrect($string)
        ) {
            $this->code = 400;
            $this->message = 'Bad Request';
        }

        header($this->protocol . ' ' . $this->code . ' ' . $this->message);
        return;
    }

    private function isEmpty(string $string): bool
    {
        return empty(trim($string));
    }

    private function isCorrect(string $string): bool
    {
        $counter = 0;
        foreach (str_split($string) as $letter) {
            if ($letter == '(') ++$counter;
            if ($letter == ')') --$counter;
            if ($counter < 0) {
                return false;
            }
        }

        if ($counter !== 0) {
            return false;
        }

        return true;
    }
}

<?php

namespace Dsergei\Hw6;

class AbstractValidator
{
    public function log(): \Generator
    {
        $string = yield;
        echo $string . PHP_EOL;
    }
}

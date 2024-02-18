<?php

namespace Dsergei\Hw4;

class CheckerString implements ICheckerInterface
{
    /**
     * @param string $string
     * @return void
     * @throws \Exception
     */
    public function check(string $string): void
    {
        if (empty($string) || strlen($string) < 1) {
            throw new \Exception('Empty string');
        }
    }
}

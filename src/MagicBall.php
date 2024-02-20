<?php

namespace Slipka007\Hw13ComposerPackage;

class MagicBall
{
    private $answers = array("Да", "Нет");

    public function getAnswer ()
    {
        $randAnswerId = array_rand($this->answers, 1);
        return $this->answers[$randAnswerId];
    }
}

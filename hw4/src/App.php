<?php

namespace Pavel\Hw4;

use PavelGoroshnikov\SimpleApi\Cat;

class App
{
    public function run(): void
    {
        $cat = new Cat();
        $fact = $cat->getFact();
        echo $fact;
    }

}

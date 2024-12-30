<?php

namespace App\Application\Composite;

class Leaf extends Component
{
    public function show(): string
    {
        return   $this->name . " " . $this->size  . PHP_EOL;
    }

}
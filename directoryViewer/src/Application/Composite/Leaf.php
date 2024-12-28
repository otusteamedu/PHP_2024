<?php

namespace App\Application\Composite;

class Leaf extends Component
{

    public function show(): string
    {
        return $this->fileInfo->getFilename() . PHP_EOL;
    }

}
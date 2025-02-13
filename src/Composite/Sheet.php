<?php

declare(strict_types=1);

namespace App\Composite;

class Sheet extends FileNode
{

    public function show(): string
    {
        return sprintf("%s %s\n", $this->name, $this->size);
    }
}
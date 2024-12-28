<?php

namespace App\Application\Composite;

use SplFileInfo;

abstract class Component
{
    protected \SplObjectStorage $children;

    public function __construct(
        protected SplFileInfo $fileInfo
    ) {
        $this->children = new \SplObjectStorage();
    }
    public function add(?Component $component): void { }

    public function remove(?Component $component): void { }


    public function isComposite(): bool
    {
        return false;
    }

    abstract public function show(): string;


}
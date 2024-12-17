<?php

abstract class DirectoryComponent
{
    public function add(?DirectoryComponent $component): void { }

    public function remove(?DirectoryComponent $component): void { }


    public function isComposite(): bool
    {
        return false;
    }

    abstract public function show(): string;
    abstract public function create(): string;


}
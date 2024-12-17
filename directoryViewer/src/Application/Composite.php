<?php

namespace App\Application;

class Composite extends \DirectoryComponent
{
    /**
     * @var \SplObjectStorage
     */
    protected $children;

    public function __construct()
    {
        $this->children = new \SplObjectStorage();
    }
    public function add(\DirectoryComponent|null $component): void
    {
        $this->children->attach($component);
    }

    public function remove(\DirectoryComponent|null $component): void
    {
        $this->children->detach($component);
    }

    public function isComposite(): bool
    {
        return true;
    }

    public function show(): string
    {
        // TODO: Implement show() method.
    }

    public function create(): string
    {
        // TODO: Implement create() method.
    }
}
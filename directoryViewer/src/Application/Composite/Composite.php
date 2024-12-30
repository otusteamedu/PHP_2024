<?php

namespace App\Application\Composite;

use SplFileInfo;

class Composite extends Component
{
    public function add(Component|null $component): void
    {
        $this->children->attach($component);
    }

    public function remove(Component|null $component): void
    {
        $this->children->detach($component);
    }

    public function isComposite(): bool
    {
        return true;
    }

    public function show(): string
    {
        $result =  $this->name . " " . $this->size . PHP_EOL;
        foreach ($this->children as $child) {
            $result .= $child->show();
        }
        return $result;
    }
}
<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Composite;

class Leaf extends Component
{
    public function display(): void
    {
        parent::display();
        $this->print($this->path);
    }
}
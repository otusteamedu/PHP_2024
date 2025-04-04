<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw15\Composite;

class Composite extends Component
{
    const MAX_SIZE_KB = 100;

    /**
     * @var Component[]
     */
    private array $children = [];

    public function add(Component $component): void
    {
        $this->children[$component->path] = $component;
    }

    public function display(): void
    {
        parent::display();
        foreach($this->children as $child) {
            if ($child->getSize() < self::MAX_SIZE_KB) {
                $child->display();
            }
        }
    }

    public function scan(): Component
    {
        if (is_file($this->path)) {
            $leaf = new Leaf($this->path, $this->extensionsToPrint);
            $leaf->setSize(filesize($this->path) / 1024);
            return $leaf;
        }
        $files = scandir($this->path);
        foreach ($files as $file) {
            if (!in_array($file, array('.', '..'))) {
                $item = (new Composite($this->path . '/' . $file, $this->extensionsToPrint))->scan();
                $this->size += $item->getSize();
                $this->add($item);
            }
        }
        return $this;
    }

}
<?php

namespace App\Application\Composite;

class HtmlLeaf extends Component
{
    const LIMIT = 50;
    public function show(): string
    {
        $preview = $this->getPreview();
        return $this->name . " " . $this->size . PHP_EOL . $preview . PHP_EOL;
    }

    private function getPreview(): ?string
    {
        $content = file_get_contents($this->fileInfo->getPathname());
        if ($content === false) {
            return null;
        }

        $content = strip_tags($content);
        return substr($content, 0, self::LIMIT);
    }

}
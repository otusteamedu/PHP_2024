<?php

declare(strict_types=1);

namespace App\Composite;

class Html extends FileNode
{
    private const LIMIT = 50;

    public function show(): string
    {
        $preview = $this->getPreview();
        return sprintf("%s %s%s%s%s", $this->name, $this->size, PHP_EOL, $preview, PHP_EOL);
    }

    private function getPreview(): ?string
    {
        $filePath = $this->file->getPathname();
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return null;
        }

        $content = file_get_contents($filePath);
        if (empty($content)) {
            return null;
        }

        $content = strip_tags($content);

        return mb_substr($content, 0, self::LIMIT);
    }
}

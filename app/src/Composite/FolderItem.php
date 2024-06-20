<?php

declare(strict_types=1);

namespace App\src\Composite;

use App\src\Contracts\FolderItemInterface;
use App\src\Handlers\AddRowToTemplate;
use App\src\Handlers\CheckSizeHandler;
use App\src\Requests\PathRequest;
use App\src\Requests\RenderRequest;
use App\src\Template;

final class FolderItem implements FolderItemInterface
{
    public function __construct(
        private readonly PathRequest $pathRequest,
        private readonly array $dirExceptions = [],
        private int $size = 0,
        private readonly \SplDoublyLinkedList $items = new \SplDoublyLinkedList()
    ) {
    }

    public function render(Template $template): void
    {
        $renderRequest = new RenderRequest(
            $this->pathRequest->path,
            pathinfo($this->pathRequest->path, PATHINFO_BASENAME),
            $this->size,
            '',
        );

        $handler = new CheckSizeHandler();
        $handler->setNext(new AddRowToTemplate());
        $handler->handle($renderRequest, $template);

        $this->items->rewind();

        while ($this->items->valid()) {
            $template->incrementTab();
            $this->items->current()->render($template);
            $template->decrementTab();
            $this->items->next();
        }
    }

    public function build(): int
    {
        $dirItems = array_diff($this->getDirItems(), $this->dirExceptions);

        foreach ($dirItems as $item) {
            $path = $this->pathRequest->path . '/' . $item;

            if (is_file($path)) {
                $this->addItemFile($path);
                continue;
            }

            if (is_dir($path)) {
                $this->addItemFolder($path);
            }
        }

        return $this->size;
    }

    private function getDirItems(): array
    {
        $scanDir = scandir($this->pathRequest->path);

        if (!$scanDir) {
            return [];
        }

        usort($scanDir, function ($a, $b) {
            $aIsFile = (int)is_file($this->pathRequest->path . '/' . $a);
            $bIsFile = (int)is_file($this->pathRequest->path . '/' . $b);

            if ($aIsFile == $bIsFile) {
                return 0;
            }

            return $aIsFile < $bIsFile ? -1 : 1;
        });

        return $scanDir;
    }

    private function addItemFile(string $path): void
    {
        $this->items->push(
            new FileItem(
                new RenderRequest(
                    $path,
                    pathinfo($path, PATHINFO_FILENAME),
                    filesize($path),
                    pathinfo($path, PATHINFO_EXTENSION),
                )
            )
        );

        $this->size += filesize($path);
    }

    private function addItemFolder(string $path): void
    {
        $folder = new FolderItem(new PathRequest($path), $this->dirExceptions);
        $this->items->push($folder);
        $this->size += $folder->build();
    }
}

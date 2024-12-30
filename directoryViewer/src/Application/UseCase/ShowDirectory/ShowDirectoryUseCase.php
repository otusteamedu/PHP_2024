<?php

namespace App\Application\UseCase\ShowDirectory;

use App\Application\Composite\Composite;
use App\Application\Composite\HtmlLeaf;
use App\Application\Composite\Leaf;
use App\Application\Composite\TxtLeaf;
use App\Domain\HandlerInterface;

use SplFileInfo;

class ShowDirectoryUseCase
{
    private HandlerInterface $handler;

    public function __invoke(ShowDirectoryRequest $request, HandlerInterface $handler): ShowDirectoryResponse
    {
        $pathToScan = $request->path->getValue();
        $this->handler = $handler;
        $composite = $this->processDirectory($pathToScan);
        return new ShowDirectoryResponse($composite->show());
    }

    private function processDirectory(string $path, int $level = 1): Composite
    {
        $it = new \DirectoryIterator($path);

        $composite = new Composite(new SplFileInfo($path), $level);
        $level++;
        foreach ($it as $fileinfo) {
            if (!$this->handler->handle($fileinfo)) {
                continue;
            }
            if ($fileinfo->isDir() && !$fileinfo->isDot()) {
                $composite->add($this->processDirectory($fileinfo->getPathname(), $level));
            }
            if ($fileinfo->isFile()) {
                $extension = strtolower($fileinfo->getExtension());
                match ($extension) {
                    'txt' => $composite->add(new TxtLeaf(new SplFileInfo($fileinfo->getPathname()), $level)),
                    'html' => $composite->add(new HtmlLeaf(new SplFileInfo($fileinfo->getPathname()), $level)),
                    default => $composite->add(new Leaf(new SplFileInfo($fileinfo->getPathname()), $level))
                };

            }
        }
        return $composite;

    }
}
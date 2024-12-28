<?php
namespace App\Application\UseCase\ShowDirectory;

use App\Application\Composite\Composite;
use App\Application\Composite\Leaf;
use FilesystemIterator;
use ShowDirectoryRequest;
use SplFileInfo;

class ShowDirectoryUseCase
{
    public function __invoke(ShowDirectoryRequest $request)
    {
        $pathToScan = $request->path->getValue();
        $composite = $this->processDirectory($pathToScan);
        return $composite->show();
    }

    private function processDirectory(string $path): Composite
    {
        $it = new FilesystemIterator($path, FilesystemIterator::CURRENT_AS_FILEINFO);

        $composite = new Composite(new SplFileInfo($path));
        foreach ($it as $fileinfo) {

            if($fileinfo->isDir()){
                $composite->add($this->processDirectory($fileinfo->getPath(). DIRECTORY_SEPARATOR . $fileinfo->getFilename()));
            }
            if($fileinfo->isFile()){
                $composite->add(new Leaf($fileinfo));
            }
        }
        return $composite;

    }
}
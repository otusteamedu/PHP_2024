<?php

namespace App\Domain\Entity;

use App\Domain\ValueObject\Extention;
use App\Domain\ValueObject\Info;
use App\Domain\ValueObject\Level;
use App\Domain\ValueObject\Path;
use App\Domain\ValueObject\Size;

class Directory
{
    private Size $size;
    private iterable $children;

    private Info $info;

    private Extention $ext;



    public function __construct(
        private Path $path,
        private Level $level
    ) {
    }

    /**
     * @return Level
     */
    public function getLevel(): Level
    {
        return $this->level;
    }

    /**
     * @return Path
     */
    public function getPath(): Path
    {
        return $this->path;
    }

    /**
     * @return Size
     */
    public function getSize(): Size
    {
        return $this->size;
    }

    /**
     * @return iterable
     */
    public function getChildren(): iterable
    {
        return $this->children;
    }

    /**
     * @return Info
     */
    public function getInfo(): Info
    {
        return $this->info;
    }

    /**
     * @return Extention
     */
    public function getExt(): Extention
    {
        return $this->ext;
    }


}
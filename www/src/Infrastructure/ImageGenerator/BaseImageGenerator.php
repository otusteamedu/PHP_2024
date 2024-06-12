<?php

declare(strict_types=1);

namespace App\Infrastructure\ImageGenerator;

abstract class BaseImageGenerator
{
    protected string|null $publicDirPath = null;
    protected string|null $imageDirPath = null;

    public function __construct(string $publicDirPath, string $imageDirPath)
    {
        $this->publicDirPath = $publicDirPath;
        $this->imageDirPath = $imageDirPath;
    }

    /**
     * @param string $description
     * @return string путь до файла
     */
    abstract public function generateImage(string $description): string;
}

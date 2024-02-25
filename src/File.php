<?php

namespace hw5;

class File
{
    /**
     * @param string $filePath
     * @param bool $isUnlink
     */
    public function __construct(
        private string $filePath,
        private bool $isUnlink = false
    ) {
        if (file_exists($this->filePath) && $this->isUnlink) {
            unlink($this->filePath);
        }
    }

    /**
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->filePath;
    }
}

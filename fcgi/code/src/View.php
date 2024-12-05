<?php

declare(strict_types=1);

namespace Otus\App;

use Exception;

class View
{
    private $contentFile;
    private $header = 'header.html';
    private $footer = 'footer.html';
    private $pathToTemplates = 'src/templates';
    public function __construct($contentFile)
    {
        if (! file_exists("{$this->pathToTemplates}/{$contentFile}")) {
            throw new Exception("File {$this->pathToTemplates}/{$contentFile} not exists");
        }
        $this->contentFile = $contentFile;
    }
    public function renderHTML()
    {
        $contents = file_get_contents("{$this->pathToTemplates}/{$this->header}");
        $contents .= file_get_contents("{$this->pathToTemplates}/{$this->contentFile}");
        $contents .= file_get_contents("{$this->pathToTemplates}/{$this->footer}");
        return $contents;
    }
}

<?php

declare(strict_types=1);

namespace IgorKachko\OtusComposerApp\Infrastructure;

use IgorKachko\OtusComposerPackage\StringProcessor;

class StringCommand
{
    public function run(): void
    {
        $processor = new StringProcessor();
        echo $processor->getLength('привет');
    }
}
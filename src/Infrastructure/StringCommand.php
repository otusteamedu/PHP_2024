<?php

declare(strict_types=1);

namespace SlavaMakhov\OtusComposerApp\Infrastructure;

use SlavaMakhov\WorkingWithString\StringProcessor;

class StringCommand
{
    public function run(): void
    {
        $stringProcessor = new StringProcessor();
        echo $stringProcessor->getCleanString('my 785 string');
    }

}
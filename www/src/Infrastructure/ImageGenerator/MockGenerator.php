<?php

declare(strict_types=1);

namespace App\Infrastructure\ImageGenerator;

class MockGenerator extends BaseImageGenerator
{
    public function generateImage(string $description): string
    {
        $files = glob($this->publicDirPath . $this->imageDirPath . '/*.*');
        $file = array_rand($files);
        sleep(15);
        return str_replace($this->publicDirPath, '', $files[$file]);
    }
}

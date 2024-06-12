<?php

declare(strict_types=1);

namespace App\Application\ImageGenerator;

interface ImageGeneratorInterface
{
    public function getImage(string $description): ImageDTO;
}
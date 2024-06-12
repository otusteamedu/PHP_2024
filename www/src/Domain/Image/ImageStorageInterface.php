<?php

declare(strict_types=1);

namespace App\Domain\Image;

interface ImageStorageInterface
{
    public function getImage(string $id): ?Image;

    public function generateImageByDescription(string $description): Image;
}

<?php

declare(strict_types=1);

namespace App\Request\News;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class CreateNewsRequest
{
    #[NotBlank]
    public string $title;

    #[NotBlank]
    public string $content;
    #[Positive]
    public int $categoryId;
}
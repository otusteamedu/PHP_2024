<?php

declare(strict_types=1);

namespace App\Request\CategorySubscribe;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class CategorySubscribeRequest
{
    #[NotBlank]
    public string $type;

    #[NotBlank]
    public string $value;

    #[NotBlank]
    #[Positive]
    public int $categoryId;
}
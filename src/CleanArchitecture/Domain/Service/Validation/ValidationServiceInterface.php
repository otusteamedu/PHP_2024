<?php

declare(strict_types=1);

namespace AlexanderGladkov\CleanArchitecture\Domain\Service\Validation;

use AlexanderGladkov\CleanArchitecture\Domain\Entity\News;

interface ValidationServiceInterface
{
    public function validateNews(News $news): array;
}

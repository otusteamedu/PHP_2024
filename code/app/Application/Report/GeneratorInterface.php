<?php

declare(strict_types=1);

namespace App\Application\Report;

use App\Domain\Entity\News;

interface GeneratorInterface
{
    /**
     * @param News[] $news
     * @return string
     */
    public function generate(array $news): string;
}

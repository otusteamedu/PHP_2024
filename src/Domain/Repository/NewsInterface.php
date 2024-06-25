<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\News;

/**
 * getById метод
 */
interface NewsInterface
{
    /**
     * @param News $news
     * @return void
     */
    public function save(News $news): void;

    /**
     * @param array $identifier
     * @return News[]|null
     */
    public function getById(array $identifier);
}

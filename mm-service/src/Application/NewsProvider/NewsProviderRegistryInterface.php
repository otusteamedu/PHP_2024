<?php

declare(strict_types=1);

namespace App\Application\NewsProvider;

use App\Application\NewsProvider\Exception\NewsProviderNotSupportedException;
use App\Domain\Entity\News;

interface NewsProviderRegistryInterface
{
    /**
     * @param mixed[] $newsDeterminationAttributes
     */
    public function supports(array $newsDeterminationAttributes): bool;

    /**
     * @param mixed[] $newsDeterminationAttributes
     *
     * @throws NewsProviderNotSupportedException
     */
    public function retrieveNews(array $newsDeterminationAttributes): News;
}

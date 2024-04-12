<?php
declare(strict_types=1);

namespace App\Application\NewsProvider;

use App\Application\NewsProvider\Exception\NewsProviderNotSupportedException;
use App\Domain\Entity\News;

interface NewsProviderRegistryInterface
{
    /**
     * @param mixed[] $newsDeterminationAttributes
     * @return bool
     */
    public function supports(array $newsDeterminationAttributes): bool;

    /**
     * @param mixed[] $newsDeterminationAttributes
     * @return News
     *
     * @throws NewsProviderNotSupportedException
     */
    public function retrieveNews(array $newsDeterminationAttributes): News;
}
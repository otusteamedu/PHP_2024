<?php
declare(strict_types=1);

namespace App\Application\NewsProvider;

use App\Domain\Entity\News;

interface NewsProviderInterface
{
    /**
     * @param mixed[] $newsDeterminationAttributes
     * @return bool
     */
    public function supports(array $newsDeterminationAttributes): bool;

    /**
     * @param mixed[] $newsDeterminationAttributes
     * @return News
     */
    public function retrieve(array $newsDeterminationAttributes): News;
}

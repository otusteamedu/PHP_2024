<?php
declare(strict_types=1);

namespace App\Application\NewsProvider;

use App\Application\NewsProvider\Exception\NewsProviderNotSupportedException;
use App\Domain\Entity\News;

class NewsProviderRegistry implements NewsProviderRegistryInterface
{
    /**
     * @param iterable<NewsProviderInterface> $newsProviders
     */
    public function __construct(
        private iterable $newsProviders,
    )
    {
    }

    public function supports(array $newsDeterminationAttributes): bool
    {
        foreach ($this->newsProviders as $provider) {
            if ($provider->supports($newsDeterminationAttributes)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $newsDeterminationAttributes
     * @return News
     *
     * @throws NewsProviderNotSupportedException
     */
    public function retrieveNews(array $newsDeterminationAttributes): News
    {
        foreach ($this->newsProviders as $provider) {
            if ($provider->supports($newsDeterminationAttributes)) {
                return $provider->retrieve($newsDeterminationAttributes);
            }
        }

        throw new NewsProviderNotSupportedException();
    }
}

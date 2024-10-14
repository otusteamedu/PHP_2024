<?php

declare(strict_types=1);

namespace App\Shared\Repository;

use App\Shared\Search\SearchCriteria;
use App\Shared\Search\SearchResults;

interface RepositoryInterface
{
    public function search(?SearchCriteria $searchCriteria = null): SearchResults;
}

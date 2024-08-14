<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Model;

use Viking311\DbPattern\Db\PdoFactory;

class MovieFinderFactory
{
    /**
     * @return MovieFinder
     */
    public static function getInstance(): MovieFinder
    {
        $pdo = PdoFactory::getPdo();

        return new MovieFinder($pdo);
    }
}

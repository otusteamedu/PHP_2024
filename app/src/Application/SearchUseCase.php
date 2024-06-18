<?php

declare(strict_types=1);

namespace Kagirova\Hw14\Application;

use Kagirova\Hw14\Infrastructure\Elastic;

class SearchUseCase
{
    public function __construct(private Elastic $elastic)
    {
    }

    public function run()
    {
        $longopts = ["title::", "category::", "price_greater_than::", "price_lesser_than::", "instock::"];
        $opts = getopt('', $longopts);

        $books = $this->elastic->search($opts);

        foreach ($books as $book) {
            $mask = "|%7s |%-80s |%-20s |%-8d |%-20s |\n";
            printf($mask, $book->getId(), $book->getTitle(), $book->getCategory(), $book->getPrice(), $book->getStock());
        }
    }
}

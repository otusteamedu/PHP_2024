<?php

declare(strict_types=1);

namespace App\old\Application\UseCase\Response;

use App\Domain\Entity\BookCollection;

class SearchBookResponse
{
    public $bookCollection;

    public function __construct(BookCollection $bookCollection)
    {
        $this->bookCollection = $bookCollection;
    }
}

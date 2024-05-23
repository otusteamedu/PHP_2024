<?php

declare(strict_types=1);

namespace App\Domain\Repository\Query;

readonly class NewsByIdsQuery
{
   public function __construct(public array $ids)
   {
   }
}

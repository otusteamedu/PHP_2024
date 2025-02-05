<?php

namespace App\Domain\Model\CheckListItem;

class CheckListItemModel
{
    public function __construct(
        public int    $id,
        public string $title,
        public string $firstName,
        public string $date,
    ) {
    }
}

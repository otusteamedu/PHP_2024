<?php

namespace App\Domain\Model\ShoppingListItem;

class ShoppingListItemModel
{
    public function __construct(
        public int    $id,
        public bool   $isPurchased,
        public int    $userId,
        public string $firstName,
        public string $userName,
        public bool   $isBot,
        public int    $date,
    ) {
    }
}

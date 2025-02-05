<?php

namespace App\Domain\Model\Purchase;

class PurchaseModel
{
    public function __construct(
        public string  $title,
        public ?bool   $isPurchased,
        public ?int    $telegramUserId,
        public ?bool   $isBot,
        public ?string $firstName,
        public ?string $userName,
        public ?int    $date,
    ) {
    }
}

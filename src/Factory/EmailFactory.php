<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Email;
use App\ValueObject\EmailStatus;

final readonly class EmailFactory
{
    public function make(
        string $id,
        EmailStatus $status,
        string $from,
        string $to,
        string $text,
    ): Email {
        return new Email(
            id: $id,
            status: $status,
            from: $from,
            to: $to,
            text: $text
        );
    }
}

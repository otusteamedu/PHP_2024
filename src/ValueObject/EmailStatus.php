<?php

declare(strict_types=1);

namespace App\ValueObject;

enum EmailStatus: string
{
    case PENDING = 'pending';
    case SENDING = 'sending';
    case SENT = 'sent';
}

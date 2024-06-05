<?php

declare(strict_types=1);

namespace Module\News\Domain\Entity;

enum Status: string
{
    case New = 'new';
    case Processing = 'processing';
    case Approving = 'approving';
    case Published = 'published';
}

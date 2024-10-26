<?php

declare(strict_types=1);

namespace App\Domain\Exception;

class NewsNotFoundException extends DomainException
{
    /**
     * @param int[] $ids
     */
    public function __construct(array $ids)
    {
        $message = sprintf('News with ids "%s" not found', implode(', ', $ids));
        parent::__construct($message);
    }
}

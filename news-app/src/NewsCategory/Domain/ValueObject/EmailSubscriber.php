<?php

declare(strict_types=1);

namespace App\NewsCategory\Domain\ValueObject;

use App\Common\Domain\ValueObject\StringValue;

readonly class EmailSubscriber extends Subscriber
{
    public const TYPE = 'email';

    public function getType(): StringValue
    {
        return StringValue::fromString(self::TYPE);
    }
}
<?php

declare(strict_types=1);

namespace App\NewsCategory\Domain\ValueObject;

use App\Common\Domain\ValueObject\StringValue;

readonly class TelegramSubscriber extends Subscriber
{
    public const TYPE = 'telegram';

    public function getType(): StringValue
    {
        return StringValue::fromString(self::TYPE);
    }
}

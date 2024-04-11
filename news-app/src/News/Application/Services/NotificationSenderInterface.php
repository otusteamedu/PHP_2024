<?php

declare(strict_types=1);

namespace App\News\Application\Services;

use App\Common\Domain\ValueObject\StringValue;
use App\NewsCategory\Domain\ValueObject\Subscriber;

interface NotificationSenderInterface
{
    public function sendNotification(StringValue $stringValue, Subscriber $subscriber): void;
}
<?php

declare(strict_types=1);

namespace App\NewsCategory\Application\Factory;

use App\Common\Domain\ValueObject\StringValue;
use App\NewsCategory\Domain\ValueObject\EmailSubscriber;
use App\NewsCategory\Domain\ValueObject\Subscriber;
use App\NewsCategory\Domain\ValueObject\TelegramSubscriber;
use InvalidArgumentException;

class SubscriberFactory
{
    private array $subscribers;

    public function __construct()
    {
        $this->subscribers = [
            'email' => EmailSubscriber::class,
            'telegram' => TelegramSubscriber::class
        ];
    }

    public function getSubscriber(string $type, string $value): Subscriber
    {
        $subscriber = $this->subscribers[$type] ?? null;

        if ($subscriber === null) {
            throw new InvalidArgumentException(sprintf('Invalid subscriber type "%s"', $type));
        }

        return new $subscriber(StringValue::fromString($value));
    }
}
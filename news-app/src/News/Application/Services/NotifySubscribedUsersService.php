<?php

declare(strict_types=1);

namespace App\News\Application\Services;

use App\Common\Domain\ValueObject\StringValue;
use App\News\Application\Factory\NotificationSenderFactory;
use App\News\Application\Observer\SubscriberInterface;
use App\News\Domain\Entity\News;
use App\NewsCategory\Domain\ValueObject\Subscriber;

class NotifySubscribedUsersService implements SubscriberInterface
{
    protected NotificationSenderFactory $notificationSenderFactory;

    public function __construct(NotificationSenderFactory $notificationSenderFactory)
    {
        $this->notificationSenderFactory = $notificationSenderFactory;
    }

    public function run(News $news): void
    {
        $category = $news->getCategory();
        $text = sprintf("Создана новая новость %s", $news->getTitle()->value());
        /** @var Subscriber $subscriber */
        foreach ($category->getSubscribers() as $subscriber) {
            $sender = $this->notificationSenderFactory->getSenderByType($subscriber->getType()->value());
            $sender->sendNotification(StringValue::fromString($text), $subscriber);
        }
    }
}
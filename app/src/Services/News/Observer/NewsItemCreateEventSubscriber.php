<?php

declare(strict_types=1);

namespace App\Services\News\Observer;

use App\Entity\Subscribe;
use Doctrine\ORM\EntityManagerInterface;

class NewsItemCreateEventSubscriber implements NewsItemSubscriberInterface
{
    public function __construct(private readonly EntityManagerInterface $em)
    {
    }

    public function notify(NewsItemCreateEvent $event): void
    {
        $category = $event->newsItem->getCategory();
        $subscribes = $this->em->getRepository(Subscribe::class)->findBy(['category' => $category]);
        foreach ($subscribes as $subscribe) {
            $email = $subscribe->getEmail();
            // далее отправляем подписчику уведомление, что вышла новая новость
            dump("отправили подписчику {$email} уведомление о новой статье в категории {$category}");
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Application\Observer;

use App\Application\Observer\PublisherInterface;
use App\Application\Observer\SubscriberInterface;

class Publisher implements PublisherInterface
{

    private array $subscribers = [];
  
    public function subscribe(SubscriberInterface $subscriber): void
    {
        // В реальности нужно проверять подписчиков на дубликаты
        $this->subscribers[] = $subscriber;
    }
  
    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        // TODO: Implement unsubscribe() method.
    }
  
    public function notify(ProductStatus $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($event);
        }
    }
}

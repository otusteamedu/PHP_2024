<?php

declare(strict_types=1);

namespace App\News\Infrastructure\Observer;

use App\News\Application\Observer\PublisherInterface;
use App\News\Application\Observer\SubscriberInterface;
use App\News\Domain\Entity\News;

class Publisher implements PublisherInterface
{
    private array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        foreach ($this->subscribers as $i => $storedSubscriber){
            if ($storedSubscriber === $subscriber){
                unset($this->subscribers[$i]);
            }
        }
    }

    public function notify(News $news): void
    {
        foreach ($this->subscribers as $subscriber){
            $subscriber->run($news);
        }
    }
}
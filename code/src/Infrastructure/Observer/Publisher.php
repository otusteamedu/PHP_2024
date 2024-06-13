<?php
declare(strict_types=1);

namespace App\Infrastructure\Observer;

use App\Application\Interface\Observer\PublisherInterface;
use App\Application\Interface\Observer\SubscriberInterface;
use App\Application\UseCase\Response\Response;

class Publisher implements PublisherInterface
{
    private array $subscribers = [];

    public function subscribe(SubscriberInterface $subscriber): void
    {
        if (in_array($subscriber, $this->subscribers, true)) {
            throw new \RuntimeException('Subscriber already exists');
        }
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(SubscriberInterface $subscriber): void
    {
        // TODO: Implement unsubscribe() method.
    }

    /**
     * @param Response $response
     * @return void
     */
    public function notify(Response $response): void
    {
        foreach ($this->subscribers as $subscriber) {
            $subscriber->update($response);
        }
    }
}
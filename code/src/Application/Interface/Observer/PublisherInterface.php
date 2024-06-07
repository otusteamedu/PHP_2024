<?php
declare(strict_types=1);

namespace App\Application\Interface\Observer;

interface PublisherInterface
{
    public function subscribe(SubscriberInterface $subscriber): void;
    public function unsubscribe(SubscriberInterface $subscriber): void;
    public function notify(int $status): void;
}
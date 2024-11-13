<?php

declare(strict_types=1);

namespace App\Application\Observer;

use App\Application\Observer\ProductStatus;
use App\Application\Observer\SubscriberInterface;

//интерфейс Издателя
interface PublisherInterface
{

    // Присоединяет наблюдателя к издателю
    public function subscribe(SubscriberInterface $subscriber): void;
    
    // Отсоединяет наблюдателя от издателя
    public function unsubscribe(SubscriberInterface $subscriber): void;
    
    // Уведомляет всех наблюдателей о событии
    public function notify(ProductStatus $event): void;
}

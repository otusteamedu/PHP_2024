<?php

declare(strict_types=1);

namespace Irayu\Hw16\Infrastructure;

use Irayu\Hw16\Application\Observer;
use Irayu\Hw16\Application\ObserverEvent;

class ClientNotifier implements Observer
{
    public function update(ObserverEvent $event): void
    {
        echo "Оповещение клиента: статус изменен на {$event->getEventName()}.\n";
    }
}

<?php

declare(strict_types=1);

namespace Irayu\Hw16\Application;

trait ObservedSubjectTrait
{
    private array $observers = [];

    public function addObserver(Observer $observer): void
    {
        $this->observers[] = $observer;
    }

    public function removeObserver(Observer $observer): void
    {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    public function triggerEvent(ObserverEvent $event): void
    {
        $this->notifyObservers($event);
    }

    private function notifyObservers(ObserverEvent $event): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($event);
        }
    }
}

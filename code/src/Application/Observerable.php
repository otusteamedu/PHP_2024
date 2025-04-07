<?php

namespace Irayu\Hw16\Application;

interface Observerable
{
    public function addObserver(Observer $observer): void;

    public function removeObserver(Observer $observer): void;

    public function triggerEvent(ObserverEvent $event): void;
}

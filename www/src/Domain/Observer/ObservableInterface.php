<?php

declare(strict_types=1);

namespace App\Domain\Observer;

interface ObservableInterface
{
    public function addObserver(ObserverInterface $observer): void;

    public function removeObserver(ObserverInterface $observer): void;

    public function notifyObservers(callable $callback): void;
}
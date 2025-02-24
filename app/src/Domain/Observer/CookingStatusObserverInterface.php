<?php

declare(strict_types=1);

namespace Otus\Hw16\Domain\Observer;

use SplSubject;

interface CookingStatusObserverInterface extends \SplObserver
{
    public function update(SplSubject $subject): void;
}

<?php

declare(strict_types=1);

namespace App\Observe;

use App\Observe\ObserverInterface;

class CookingStatusObserver implements ObserverInterface
{
    /** @param CookingStatusSubject $subject */
    public function update(SubjectInterface $subject): void
    {
        echo "Статус готовки: {$subject->getCookingStatus()->value}\n";
    }
}

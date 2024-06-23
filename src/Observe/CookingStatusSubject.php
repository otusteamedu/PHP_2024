<?php

declare(strict_types=1);

namespace App\Observe;

use App\Enum\CookingStatusEnum;

class CookingStatusSubject implements SubjectInterface
{
    /** @var ObserverInterface[]  */
    private array $observers = [];
    private ?CookingStatusEnum $cookingStatus = null;

    public function getCookingStatus(): ?CookingStatusEnum
    {
        return $this->cookingStatus;
    }

    public function setCookingStatus(CookingStatusEnum $cookingStatus): void
    {
       $this->cookingStatus = $cookingStatus;
    }

    public function attach(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer): void
    {
        foreach ($this->observers as $index => $obs) {
           if ($obs === $observer) {
               unset($this->observers[$index]);
           }
        }
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }
}

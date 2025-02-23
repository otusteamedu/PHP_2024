<?php

namespace Otus\Hw16\Domain\Entity;

class CookingProcess implements \SplSubject
{
    private string $status;
    private \SplObjectStorage $observers;

    public function __construct(string $status = 'pending')
    {
        $this->status = $status;
        $this->observers = new \SplObjectStorage();
    }

    public function attach(\SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function withStatus(string $status): self
    {
        $new = clone $this;
        $reflection = new \ReflectionProperty(self::class, 'status');
        $reflection->setAccessible(true);
        $reflection->setValue($new, $status);
        $new->notify();
        return $new;
    }
}

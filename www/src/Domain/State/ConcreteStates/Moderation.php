<?php

declare(strict_types=1);

namespace App\Domain\State\ConcreteStates;

use App\Domain\State\AbstractState;

class Moderation extends AbstractState
{
    protected array $allowedStates = [
        Deleted::class,
        Draft::class,
        Published::class,
    ];

    public static function getName(): string
    {
        return 'moderation';
    }

    public function getNewsNotificationCallback(int $newsId): callable
    {
        return function (array $news) {
            return $news;
        };
    }
}

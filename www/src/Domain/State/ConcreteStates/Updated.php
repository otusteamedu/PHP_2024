<?php

declare(strict_types=1);

namespace App\Domain\State\ConcreteStates;

use App\Domain\State\AbstractState;

class Updated extends AbstractState
{
    protected array $allowedStates = [
        Moderation::class,
        Deleted::class,
    ];

    public static function getName(): string
    {
        return 'updated';
    }

    public function getNewsNotificationCallback(int $newsId): callable
    {
        return function (array $news) use ($newsId) {
            return array_unique(array_merge($news, [$newsId]));
        };
    }
}

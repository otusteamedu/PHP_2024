<?php

declare(strict_types=1);

namespace App\Domain\State\ConcreteStates;

use App\Domain\State\AbstractState;

class Deleted extends AbstractState
{
    protected array $allowedStates = [
        Draft::class,
        Moderation::class,
    ];

    public static function getName(): string
    {
        return 'deleted';
    }

    public function getNewsNotificationCallback(int $newsId): callable
    {
        return function (array $news) use ($newsId) {
            return array_diff($news, [$newsId]);
        };
    }
}

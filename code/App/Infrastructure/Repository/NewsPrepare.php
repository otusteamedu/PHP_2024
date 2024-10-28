<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Decorator\NewsDecoratorInterface;

class NewsPrepare implements NewsDecoratorInterface
{
    private string $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    public function getText(): string
    {
        return $this->text;
    }
}
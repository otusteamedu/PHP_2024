<?php

declare(strict_types=1);

namespace App\Infrastructure\Decorator;

use App\Domain\Decorator\NewsDecoratorInterface;

class NewsLinkDecorator implements NewsDecoratorInterface
{
    private NewsDecoratorInterface $newsDecorator;

    public function __construct(
        NewsDecoratorInterface $newsDecorator
    )
    {
        $this->newsDecorator = $newsDecorator;
    }

    public function getText(): string
    {
        return $this->newsDecorator->getText() . PHP_EOL . 'Ссылка : https://www.google.com';
    }
}
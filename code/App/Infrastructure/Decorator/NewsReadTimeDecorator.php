<?php

declare(strict_types=1);

namespace App\Infrastructure\Decorator;

use App\Domain\Decorator\NewsDecoratorInterface;

class NewsReadTimeDecorator implements NewsDecoratorInterface
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
        $text = $this->newsDecorator->getText();
        return $text . PHP_EOL . 'Время на чтение: '. mb_strlen($text) * 0.2 . 'с';
    }
}
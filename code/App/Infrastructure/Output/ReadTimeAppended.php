<?php

declare(strict_types=1);

namespace App\Infrastructure\Output;

use App\Domain\Entity\News;
use App\Domain\Output\AppendedTextInterface;
use App\Domain\ValueObject\Text;

class ReadTimeAppended implements AppendedTextInterface
{
    private AppendedTextInterface $appendedText;
    public function __construct(
        AppendedTextInterface $appendedText
    )
    {
        $this->appendedText = $appendedText;
    }

    public function getText(): Text
    {
        // todo тут вытащить и отредактировать текст
        return $this->appendedText->getText();
    }
}
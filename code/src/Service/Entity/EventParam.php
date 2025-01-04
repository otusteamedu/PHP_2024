<?php

declare(strict_types=1);

namespace App\Service\Entity;

class EventParam
{
    private string $title;
    private string $value;

    public function __construct(
    ) {

    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): EventParam
    {
        $this->title = $title;
        return $this;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function setValue(string $value): EventParam
    {
        $this->value = $value;
        return $this;
    }

    public function __serialize(): array
    {
        return [
            'title' => $this->getTitle(),
            'value' => $this->getValue(),
        ];
    }
}
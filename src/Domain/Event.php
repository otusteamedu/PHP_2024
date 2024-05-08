<?php

namespace AKornienko\Php2024\Domain;

readonly class Event
{
    private string $name;
    private string $description;

    public function __construct($name, $description)
    {
        $this->assertEventIsValid($name, $description);
        $this->name = $name;
        $this->description = $description;
    }

    private function assertEventIsValid($name, $description)
    {
        if (!$name || !$description) {
            throw new \InvalidArgumentException(
                "Задайте имя и описание события"
            );
        }
    }

    public function getValue(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
        ];
    }
}

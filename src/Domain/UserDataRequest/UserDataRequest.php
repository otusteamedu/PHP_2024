<?php

namespace AKornienko\Php2024\Domain\UserDataRequest;

class UserDataRequest
{
    private string $name;
    private string $email;

    public function __construct($name, $email)
    {
        $this->assertUserDataIsValid($name, $email);
        $this->name = $name;
        $this->email = $email;
    }

    private function assertUserDataIsValid($name, $email): void
    {
        if (!$name || !$email) {
            throw new \InvalidArgumentException(
                "Задайте имя и email"
            );
        }
    }

    public function getValue(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
        ];
    }
}

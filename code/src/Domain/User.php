<?php

declare(strict_types=1);

namespace Irayu\Hw0\Domain;

class User
{
    private int $id;
    private string $name;
    private string $email;
    private array $roles;

    // Getters and setters
    public function __construct(
        int $id,
        string $name,
        string $email,
        array $roles
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->roles = $roles;
    }

    public function isAdmin(): bool
    {
        return in_array('admin', $this->roles, true);
    }

    public function isJudge(): bool
    {
        return in_array('judge', $this->roles, true);
    }

    public function isParticipant(): bool
    {
        return in_array('participant', $this->roles, true);
    }
}

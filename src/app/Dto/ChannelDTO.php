<?php

declare(strict_types=1);

namespace App\Dto;

final readonly class ChannelDTO
{
    public function __construct(
        private string $id,
        private string $name,
        private string $description
    )
    {
    }


    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}

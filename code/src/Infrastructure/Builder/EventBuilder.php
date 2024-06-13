<?php

namespace App\Infrastructure\Builder;

use App\Application\UseCase\Response\Response;

class EventBuilder
{
    private string $recipe;
    private string $status;
    private ?string $additional;
    private int $id;

    public function build(): Response
    {
        return new Response(
            $this->status,
            $this->recipe,
            $this->additional,
        );
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getRecipe(): string
    {
        return $this->recipe;
    }

    public function setRecipe(string $recipe): void
    {
        $this->recipe = $recipe;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getAdditional(): ?string
    {
        return $this->additional;
    }

    public function setAdditional(?string $additional): void
    {
        $this->additional = $additional;
    }


}
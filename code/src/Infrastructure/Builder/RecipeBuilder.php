<?php

namespace App\Infrastructure\Builder;

use App\Domain\Entity\Product;

class RecipeBuilder
{
    private string $type;
    private ?string $baseRecept;
    private ?string $additional;
    private ?string $comment;


    public function build(): Product
    {
        return new Product(
            $this->getType(),
            $this->getRecipe(),
            $this->getComment()
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): void
    {
        $this->type = $type;
    }

    public function getBaseRecept(): ?string
    {
        return $this->baseRecept;
    }

    public function setBaseRecept(?string $baseRecept): void
    {
        $this->baseRecept = $baseRecept;
    }

    public function getAdditional(): ?string
    {
        return $this->additional;
    }

    public function setAdditional(?string $additional): void
    {
        $this->additional = $additional;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }

    private function getRecipe(): string
    {
        return $this->baseRecept. $this->additional;
    }


}
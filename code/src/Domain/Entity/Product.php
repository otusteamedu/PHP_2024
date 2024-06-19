<?php
declare(strict_types=1);
namespace App\Domain\Entity;

class Product
{
    private int $id;
    private string $type;
    private string $recipe;
    private ?string $comment;
    private int $status;


    public function __construct(
        string $type,
        string $recipe,
        string $comment = null,
        int $status = 1
    ){
        $this->type = $type;
        $this->recipe = $recipe;
        $this->comment = $comment;
        $this->status = $status;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getRecipe(): string
    {
        return $this->recipe;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): void
    {
        $this->comment = $comment;
    }



}
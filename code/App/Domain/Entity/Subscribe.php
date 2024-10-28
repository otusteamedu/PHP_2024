<?php
namespace App\Domain\Entity;

use App\Domain\ValueObject\Category;
use App\Domain\ValueObject\UserId;

class Subscribe
{
    private ?int $id = null;
    private Category $category;
    private UserId $user_id;

    public function __construct(
        UserId $user_id,
        Category $category
    )
    {
        $this->user_id = $user_id;
        $this->category = $category;
    }


    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUserId(): ?UserId
    {
        return $this->user_id;
    }
    public function getCategory(): Category
    {
        return $this->category;
    }
}
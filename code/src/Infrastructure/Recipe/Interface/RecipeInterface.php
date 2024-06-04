<?php
declare(strict_types=1);

namespace App\Infrastructure\Recipe\Interface;

interface RecipeInterface
{
    public function getRecipe(): string;

}
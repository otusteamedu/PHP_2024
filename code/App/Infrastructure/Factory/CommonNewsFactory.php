<?php

declare(strict_types=1);

namespace App\Infrastructure\Factory;

use App\Domain\Entity\News;
use App\Domain\Factory\NewsFactoryInterface;
use App\Domain\ValueObject\Name;
use App\Domain\ValueObject\Text;
use App\Domain\ValueObject\Author;
use App\Domain\ValueObject\Category;

class CommonNewsFactory implements NewsFactoryInterface
{

    public function create(string $name, string $author, string $category, string $text): News
    {
        return new News(
            new Name($name),
            new Author($author),
            new Category($category),
            new Text($text)
        );
    }
}
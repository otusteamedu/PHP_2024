<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Domain\Category\Category;
use Exception;
use Psr\Http\Message\ResponseInterface as Response;

class CreateCategoryAction extends BaseCategoryAction
{
    protected function action(): Response
    {
        $rawBody = $this->request->getParsedBody();

        if (empty($rawBody['title'])) {
            throw new Exception("No title");
        }

        $category = new Category(title: $rawBody['title']);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $this->respondWithData($category);
    }
}

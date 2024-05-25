<?php

declare(strict_types=1);

namespace App\Application\Actions\Category;

use App\Application\Actions\Action;
use App\Domain\Category\Category;
use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class AddSubscriberCategoryAction extends Action
{
    protected function action(): Response
    {
        $session = $this->request->getAttribute('session');
        $categoryId = (int)$this->resolveArg('category_id');

        $user = $this->entityManager->find(User::class, $session['username']);
        $category = $this->entityManager->find(Category::class, $categoryId);

        $category->addObserver($user);
        $this->entityManager->flush();

        return $this->respondWithData($category);
    }
}

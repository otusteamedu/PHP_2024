<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Domain\Category\Category;
use App\Domain\News\News;
use App\Domain\State\ConcreteStates\Draft;
use App\Domain\User\User;
use DateTime;
use Psr\Http\Message\ResponseInterface;

class CreateNewsAction extends BaseNewsAction
{
    protected function action(): ResponseInterface
    {
        $rawNews = $this->request->getParsedBody();
        $session = $this->request->getAttribute('session');

        $user = $this->entityManager->find(User::class, $session['username']);
        $category = $this->entityManager->find(Category::class, $rawNews['category']);

        $news = new News(
            null,
            title: $rawNews['title'],
            author: $user,
            createdAt: new DateTime(),
            category: $category,
            body: $rawNews['body'],
            state: new Draft()
        );

        $this->entityManager->persist($news);
        $this->entityManager->flush();

        return $this->respondWithData($news);
    }
}
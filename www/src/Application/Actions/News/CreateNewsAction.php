<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Domain\News\News;
use App\Domain\State\ConcreteStates\Draft;
use Psr\Http\Message\ResponseInterface;

class CreateNewsAction extends NewsAction
{
    protected function action(): ResponseInterface
    {
        $rawNews = $this->request->getParsedBody();
        $session = $this->request->getAttribute('session');

        $user = $this->userRepository->findById($session['username']);
        $category = $this->categoryRepository->findById($rawNews['category']);

        $news = new News(
            null,
            title: $rawNews['title'],
            author: $user,
            createdAt: new \DateTime(),
            category: $category,
            body: $rawNews['body'],
            state: new Draft()
        );

        $this->newsRepository->save($news);

        return $this->respondWithData($news);
    }
}
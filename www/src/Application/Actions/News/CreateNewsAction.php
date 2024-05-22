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
        $username = $session['username'];
        $user = $this->userRepository->findById($username);
        $categoryId = $rawNews['category'];
        $category = $this->categoryRepository->findById($categoryId);

        try {
            $news = new News(
                null,
                title: $rawNews['title'],
                author: $user,
                createdAt: new \DateTime(),
                category: $category,
                body: $rawNews['body'],
            );

            $this->newsRepository->save($news);

            return $this->respondWithData($news);
        } catch (\Throwable $throwable) {
            throw $throwable;
        }
//        return $this->respondWithData($user);
    }
}
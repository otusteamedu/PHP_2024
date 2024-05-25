<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Application\Actions\Action;
use App\Domain\News\News;
use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class ListUserNewsAction extends Action
{
    protected function action(): Response
    {
        $session = $this->request->getAttribute('session');

        /** @var User $user */
        $user = $this->entityManager->find(User::class, $session['username']);

        $news = $this->entityManager->getRepository(News::class)->findBy(['id' => $user->getNews()]);

        $user->setNews([]);
        $this->entityManager->flush();

        return $this->respondWithData($news);
    }
}

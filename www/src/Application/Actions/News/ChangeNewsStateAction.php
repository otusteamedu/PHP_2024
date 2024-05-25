<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Domain\News\News;
use App\Domain\State\AbstractState;
use Psr\Http\Message\ResponseInterface as Response;

class ChangeNewsStateAction extends BaseNewsAction
{

    protected function action(): Response
    {
        $newsId = (int)$this->resolveArg('id');
        $rawNews = $this->request->getParsedBody();

        $newState = AbstractState::getStateFromScalar($rawNews['state']);

        $news = $this->entityManager->find(News::class, $newsId);

        $news->setState($newState);
        $news->getCategory()->notifyObservers($news->getState()->getNewsNotificationCallback($newsId));

        $this->entityManager->flush();
        return $this->respondWithData($news);
    }
}
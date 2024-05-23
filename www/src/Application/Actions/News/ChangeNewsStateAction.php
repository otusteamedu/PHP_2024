<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Domain\State\AbstractState;
use Psr\Http\Message\ResponseInterface as Response;

class ChangeNewsStateAction extends NewsAction
{

    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $newState = (int) $this->resolveArg('state');
        $newState = AbstractState::getStateFromScalar($newState);

        $news = $this->newsRepository->findNewsOfId($userId);
        $news->setState($newState);

        $news = $this->newsRepository->updateState($news);

        return $this->respondWithData($news);
    }
}
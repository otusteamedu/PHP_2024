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

        $user = $this->newsRepository->findNewsOfId($userId);
        $user->setState($newState);

        $this->newsRepository->update($user);

        return $this->respondWithData($user);
    }
}
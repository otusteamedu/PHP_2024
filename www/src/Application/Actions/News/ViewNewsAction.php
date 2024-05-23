<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use Psr\Http\Message\ResponseInterface as Response;

class ViewNewsAction extends NewsAction
{
    protected function action(): Response
    {
        $userId = (int) $this->resolveArg('id');
        $user = $this->newsRepository->findNewsOfId($userId);

        return $this->respondWithData($user);
    }
}
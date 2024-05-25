<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Domain\News\News;
use Psr\Http\Message\ResponseInterface as Response;

class ViewNewsAction extends BaseNewsAction
{
    protected function action(): Response
    {
        $id = (int)$this->resolveArg('id');
        $user = $this->entityManager->find(News::class, $id);
        return $this->respondWithData($user);
    }
}
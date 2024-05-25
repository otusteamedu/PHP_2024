<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use App\Domain\News\News;
use Slim\Psr7\Response;

class ListNewsAction extends BaseNewsAction
{
    protected function action(): Response
    {
        $users = $this->entityManager->getRepository(News::class)->findAll();
        return $this->respondWithData($users);
    }
}

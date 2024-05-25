<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class ListUsersAction extends BaseUserAction
{

    protected function action(): Response
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        return $this->respondWithData($users);
    }
}

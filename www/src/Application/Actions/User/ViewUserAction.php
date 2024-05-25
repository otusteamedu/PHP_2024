<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends BaseUserAction
{
    protected function action(): Response
    {
        $username = $this->resolveArg('username');
        $user = $this->entityManager->find(User::class, $username);
        return $this->respondWithData($user);
    }
}

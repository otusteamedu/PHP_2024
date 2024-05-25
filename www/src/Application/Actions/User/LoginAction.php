<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends BaseUserAction
{

    protected function action(): Response
    {
        $rawBody = $this->request->getParsedBody();
        $username = $rawBody['username'];

        $user = $this->entityManager->find(User::class, $username);

        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        $_SESSION['username'] = $user->getUsername();
        return $this->respondWithData($user->getUsername());
    }
}
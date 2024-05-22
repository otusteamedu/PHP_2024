<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends UserAction
{

    protected function action(): Response
    {
        $rawBody = $this->request->getParsedBody();
        $username = $rawBody['username'];

        $user = $this->userRepository->findById($username);

        session_start();
        $_SESSION['username'] = $user->getUsername();
        return $this->respondWithData($user->getUsername());
    }
}
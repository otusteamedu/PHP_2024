<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use Psr\Http\Message\ResponseInterface as Response;

class ViewUserAction extends UserAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $username = $this->resolveArg('username');
        $user = $this->userRepository->findById($username);

        $this->logger->info("User of id `{$username}` was viewed.");

        return $this->respondWithData($user);
    }
}

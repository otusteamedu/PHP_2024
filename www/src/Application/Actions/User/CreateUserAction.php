<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use App\Infrastructure\Entity\User as EntityUser;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateUserAction extends UserAction
{

    protected function action(): Response
    {
        $rawBody = $this->request->getParsedBody();

        if (empty($rawBody['username'])) {
            throw new HttpBadRequestException($this->request);
        }
        $user = new User($rawBody['username']);


        $this->userRepository->save(new EntityUser(
            $user->getUsername(),
                []
            )
        );

        return $this->respondWithData($user);
    }
}
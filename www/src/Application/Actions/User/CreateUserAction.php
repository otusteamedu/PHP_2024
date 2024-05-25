<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Domain\User\User;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class CreateUserAction extends BaseUserAction
{
    protected function action(): Response
    {
        $rawBody = $this->request->getParsedBody();

        if (empty($rawBody['username'])) {
            throw new HttpBadRequestException($this->request);
        }
        $user = new User($rawBody['username']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $this->respondWithData($user);
    }
}

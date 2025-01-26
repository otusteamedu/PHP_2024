<?php

namespace Src\Application\UseCase\SetStatement;

use Src\Domain\Interface\PublisherInterface;
use Src\Domain\Repository\UserRepositoryInterface;

class SetStatementUseCase
{
    private PublisherInterface $publisher;
    private UserRepositoryInterface $userRepository;

    public function __construct(PublisherInterface $publisher, UserRepositoryInterface $userRepository)
    {
        $this->publisher = $publisher;
        $this->userRepository = $userRepository;
    }

    public function __invoke(SetStatementRequest $request): SetStatementResponse
    {
        $email = $this->userRepository->findEmailById($request->user_id);

        $message = [
            'email' => $email,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date,
            'user_id' => $request->user_id
        ];

        $this->publisher->sendMessageToChannel('statement', json_encode($message));

        return new SetStatementResponse(
            $email
        );
    }
}
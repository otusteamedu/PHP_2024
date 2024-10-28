<?php

declare(strict_types=1);

namespace App\Application\UseCase\SubmitSubscribe;

use App\Domain\Factory\SubscribeFactoryInterface;
use App\Domain\Repository\SubscribeRepositoryInterface;

class SubmitSubscribeUseCase
{
    private SubscribeFactoryInterface $subscribeFactory;
    private SubscribeRepositoryInterface $subscribeRepository;
    public function __construct(
        SubscribeFactoryInterface $subscribeFactory,
        SubscribeRepositoryInterface $subscribeRepository
    )
    {
        $this->subscribeFactory = $subscribeFactory;
        $this->subscribeRepository = $subscribeRepository;
    }

    public function __invoke(SubmitSubscribeRequest $request): SubmitSubscribeResponse
    {
        $subscribe = $this->subscribeFactory->create($request->user_id, $request->category);
        $this->subscribeRepository->save($subscribe);

        return new SubmitSubscribeResponse(
            $subscribe->GetId()
        );
    }
}
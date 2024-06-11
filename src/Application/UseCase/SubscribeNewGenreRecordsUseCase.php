<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\DTO\SuccessSubscribedDto;
use App\Application\UseCase\Request\SubscribeNewGenreRecordsRequest;
use App\Application\UseCase\Response\SubscribeNewGenreRecordsResponse;
use App\Domain\Entity\UserGenreSubscription;
use App\Domain\Repository\IUserGenreSubscriptionRepository;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Genre;

class SubscribeNewGenreRecordsUseCase
{
    public function __construct(
        public readonly IUserGenreSubscriptionRepository $genreSubscriptionRepository,
    ) {
    }

    public function __invoke(SubscribeNewGenreRecordsRequest $request): SubscribeNewGenreRecordsResponse
    {
        $subscription = new UserGenreSubscription(new Email($request->user), new Genre($request->genre));
        $this->genreSubscriptionRepository->save($subscription);

        return new SubscribeNewGenreRecordsResponse(
            new SuccessSubscribedDto(
                'Вы успешно подписаны на новый треки жанра ' . $request->genre,
            )
        );
    }
}

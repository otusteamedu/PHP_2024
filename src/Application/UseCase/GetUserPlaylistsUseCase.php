<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Mapper\IObjectMapper;
use App\Application\UseCase\DTO\GetUserPlaylistDto;
use App\Application\UseCase\Request\GetPlaylistsByUserRequest;
use App\Application\UseCase\Response\GetUserPlaylistsResponse;
use App\Domain\Repository\IPlaylistRepository;
use App\Domain\ValueObject\Email;

class GetUserPlaylistsUseCase
{
    public function __construct(
        private readonly IPlaylistRepository $playlistRepository,
        private readonly IObjectMapper $mapper2,
    ) {
    }

    public function __invoke(GetPlaylistsByUserRequest $getPlaylistsByUserRequest): GetUserPlaylistsResponse
    {
        $playlists = $this->playlistRepository->findPlaylistsByUser(
            new Email($getPlaylistsByUserRequest->user)
        );

        $response = $this->mapper2->map($playlists, GetUserPlaylistDto::class);

        return new GetUserPlaylistsResponse($response);
    }
}

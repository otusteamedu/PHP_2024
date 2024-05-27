<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Mapper\IMapper;
use App\Application\UseCase\Request\GetPlaylistsByUserRequest;
use App\Application\UseCase\Response\GetUserPlaylistsResponse;
use App\Domain\Collection\PlaylistCollection;
use App\Domain\Repository\IPlaylistRepository;
use App\Domain\ValueObject\Email;

class GetUserPlaylistsUseCase
{
    public function __construct(
        private readonly IPlaylistRepository $playlistRepository,
        private readonly IMapper $mapper,
    ) {
    }

    public function __invoke(GetPlaylistsByUserRequest $getPlaylistsByUserRequest): GetUserPlaylistsResponse
    {
        $playlists = $this->playlistRepository->findPlaylistsByUser(
            new Email($getPlaylistsByUserRequest->user)
        );
        /** @var PlaylistCollection $response */
        $response = $this->mapper->map($playlists);

        return new GetUserPlaylistsResponse($response);
    }
}

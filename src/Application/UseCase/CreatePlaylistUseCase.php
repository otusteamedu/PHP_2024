<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreatePlaylistRequest;
use App\Application\UseCase\Response\CreatePlaylistResponse;
use App\Domain\Entity\Playlist;
use App\Domain\Repository\IPlaylistRepository;
use App\Domain\Repository\ITrackRepository;

class CreatePlaylistUseCase
{
    public function __construct(
        private readonly IPlaylistRepository $playlistRepository,
        private readonly ITrackRepository $trackRepository,
    ) {
    }

    public function __invoke(CreatePlaylistRequest $request): CreatePlaylistResponse
    {
        $tracks = $this->trackRepository->findTracksById($request->tracks);
        $playlist = Playlist::createEmptyPlaylist($request->user, $request->name, $tracks);
        $this->playlistRepository->save($playlist);

        return new CreatePlaylistResponse($playlist->getId());
    }
}

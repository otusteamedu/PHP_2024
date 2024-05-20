<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreatePlaylistRequest;
use App\Application\UseCase\Response\CreatePlaylistResponse;
use App\Domain\Entity\Playlist;
use App\Domain\Repository\IPlaylistRepository;

class CreatePlaylistUseCase
{
    public function __construct(
        private readonly IPlaylistRepository $playlistRepository
    ) {
    }

    public function __invoke(CreatePlaylistRequest $request): CreatePlaylistResponse
    {
        $playlist = Playlist::createEmptyPlaylist($request->user, $request->name);
        $this->playlistRepository->save($playlist);

        return new CreatePlaylistResponse($playlist->getId());
    }
}

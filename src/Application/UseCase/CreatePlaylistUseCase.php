<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\DTO\CreatedPlaylistDto;
use App\Application\UseCase\Request\CreatePlaylistRequest;
use App\Application\UseCase\Response\CreatePlaylistResponse;
use App\Domain\Entity\Playlist;
use App\Domain\Repository\IPlaylistRepository;
use App\Domain\Repository\ITrackRepository;
use App\Domain\ValueObject\Email;

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
        $playlist = (new Playlist(
            new Email($request->user),
            $request->name
        ))
            ->setTrackCollection($tracks);
        $this->playlistRepository->save($playlist);

        return new CreatePlaylistResponse(new CreatedPlaylistDto($playlist->getId()));
    }
}

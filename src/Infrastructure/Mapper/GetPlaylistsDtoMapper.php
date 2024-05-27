<?php

declare(strict_types=1);

namespace App\Infrastructure\Mapper;

use App\Application\Mapper\IMapper;
use App\Application\UseCase\DTO\GetUserPlaylistDto;
use App\Application\UseCase\DTO\TrackDto;
use App\Domain\Collection\PlaylistCollection;
use App\Domain\Entity\Playlist;
use App\Domain\Entity\Track;
use App\Domain\Service\Decorator\TrackDurationAddDescription;

class GetPlaylistsDtoMapper implements IMapper
{
    /**
     * @param PlaylistCollection $object
     * @return PlaylistCollection
     */
    public function map(object $object): object
    {
       return $object->map(
            function (Playlist $playlist) {
                return new GetUserPlaylistDto(
                    $playlist->getId(),
                    $playlist->getName(),
                    $playlist->getTracks()->map(
                        function (Track $track) {
                            return new TrackDto(
                                $track->getId(),
                                $track->getName(),
                                $track->getAuthor(),
                                $track->getGenre()->getValue(),
                                (new TrackDurationAddDescription($track->getDuration()))->getFormatedDuration(),
                            );
                        }
                    )
                        ->toArray()
                );
            }
        );
    }
}

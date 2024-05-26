<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\GetPlaylistsByUserRequest;
use App\Application\UseCase\Response\GetUserPlaylistsResponse;

class GetUserPlaylistsUseCase
{
    public function __construct()
    {
    }

    public function __invoke(GetPlaylistsByUserRequest $getPlaylistsByUserRequest): GetUserPlaylistsResponse
    {
        return new GetUserPlaylistsResponse([]);
    }
}

<?php

declare(strict_types=1);

namespace App\Application\UseCase\Request;

readonly class GetPlaylistsByUserRequest
{
    public function __construct(
        public ?string $user,
    ) {
    }
}

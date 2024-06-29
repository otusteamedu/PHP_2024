<?php

declare(strict_types=1);

use Kagirova\Hw31\Application\SenderUseCase\GetMessageUseCase;
use Kagirova\Hw31\Application\SenderUseCase\PostDataUseCase;
use Kagirova\Hw31\Domain\Request;

return [
    Request::METHOD_GET => [
        "get_message" => [GetMessageUseCase::class]
    ],
    Request::METHOD_POST => [
        "add_message" => [PostDataUseCase::class],
    ]
];

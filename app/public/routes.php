<?php

declare(strict_types=1);

use Kagirova\Hw21\Application\Request\Request;
use Kagirova\Hw21\Application\UseCase\AddNewsUseCase;
use Kagirova\Hw21\Application\UseCase\GetNewsUseCase;
use Kagirova\Hw21\Application\UseCase\SubscribeToCategoryUseCase;

return [
    Request::METHOD_GET => [
        "get_news" => [GetNewsUseCase::class]
    ],
    Request::METHOD_POST => [
        "add_news" => [AddNewsUseCase::class],
        "subscribe" => [SubscribeToCategoryUseCase::class],
    ]
];

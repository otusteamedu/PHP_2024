<?php

declare(strict_types=1);

namespace AlexanderGladkov\App\Response;

enum StatusCode: int
{
    case OK = 200;
    case BadRequest = 400;
    case RequestMethodNotAllowed = 405;
}

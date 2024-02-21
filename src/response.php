<?php

declare(strict_types=1);

namespace Response;

function prepareGoodResponse(): void
{
    http_response_code(200);
}

function prepareBadResponse(): void
{
    http_response_code(400);
}

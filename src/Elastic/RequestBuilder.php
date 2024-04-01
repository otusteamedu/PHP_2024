<?php

declare(strict_types=1);

namespace Pozys\OtusShop\Elastic;

class RequestBuilder
{
    static public function baseRequest(?string $index = null): array
    {
        $index ??= getenv('INDEX_NAME');

        return ['index' => $index];
    }

    static public function setBody(array $request, array $body): array
    {
        $request['body'] = $body;

        return $request;
    }
}

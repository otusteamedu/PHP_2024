<?php

declare(strict_types=1);

namespace App\Infrastructure\Helpers;

use App\Application\Helpers\GetTitleInterface;
use App\Application\Helpers\GetTitleNewsRequest;
use App\Application\Helpers\GetTitleNewsResponse;

class GetTitleFromHtml implements GetTitleInterface
{
    public function getTitle(GetTitleNewsRequest $response): GetTitleNewsResponse
    {
        $title = "";
        preg_match('|<title>(.*)</title>|mi', $response->html, $result);
        if (isset($result[1])) {
            $title = $result[1];
        } else {
            throw new \DomainException('Error get site title');
        }

        return new GetTitleNewsResponse($title);
    }
}

<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\ParseNewsTitleRequest;
use App\Application\UseCase\Response\ParseNewsTitleResponse;
use App\Domain\Exceptions\Validate\UrlValidateException;
use App\Domain\ValueObject\Url;

class ParseNewsTitle
{
    /**
     * @throws UrlValidateException
     */
    public function __invoke(ParseNewsTitleRequest $request): ParseNewsTitleResponse
    {
        $title = $this->parsePageTitle($request->url);

        return new ParseNewsTitleResponse($title);
    }

    /**
     * @throws UrlValidateException
     */
    private function parsePageTitle(string $url): string
    {
        $content = file_get_contents((new Url($url))->getValue());
        preg_match("/<title>(.+?)<\/title>/", $content, $match);

        return $match[1] ?? '';
    }
}

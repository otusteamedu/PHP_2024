<?php

namespace AlexanderGladkov\CleanArchitecture\Infrastructure\Service\ParseUrl;

use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\ParseUrlParams;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\ParseUrlResult;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\ParseUrlServiceInterface;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\TitleNotFoundException;
use AlexanderGladkov\CleanArchitecture\Application\Service\ParseUrl\UrlNotFoundException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class ParseUrlService implements ParseUrlServiceInterface
{
    public function __construct(private Client $httpClient)
    {
    }

    /**
     * @throws UrlNotFoundException
     * @throws TitleNotFoundException
     */
    public function parse(ParseUrlParams $params): ParseUrlResult
    {
        try {
            $httpResponse = $this->httpClient->get($params->getUrl());
            $html = $httpResponse->getBody()->getContents();
        } catch (ConnectException) {
            throw new UrlNotFoundException('Не удалось найти страницу по данному URL');
        } catch (GuzzleException $e) {
            throw new RuntimeException($e->getMessage());
        }

        $matches = [];
        $result = preg_match('/<title(?:[^>]*)>(.*)<\/title>/', $html, $matches);
        if ($result === false || $result === 0) {
            throw new TitleNotFoundException('Не удалось найти заголовок');
        }

        return new ParseUrlResult($matches[1]);
    }
}

<?php

namespace App\Infrastructure\Service\Gateway;

use App\Application\Gateway\UrlGatewayInterface;
use App\Application\Gateway\UrlGatewayRequest;
use App\Application\Gateway\UrlGatewayResponse;

class CurlGateway implements UrlGatewayInterface
{
    public function getTitle(UrlGatewayRequest $request): UrlGatewayResponse
    {
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_AUTOREFERER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_ENCODING => '',
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            CURLOPT_HTTPHEADER => [
                'Accept: text/html,application/xhtml+xml',
                'Accept-Language: en-US,en;q=0.9',
            ],
        );
        $ch = curl_init($request->url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        preg_match('#<title>(.*?)</title>#is', $content, $matches);
        $title = trim($matches[1]);
        $title = html_entity_decode($title, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        return new UrlGatewayResponse($title);
    }
}

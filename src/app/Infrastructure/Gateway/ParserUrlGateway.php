<?php

namespace App\Infrastructure\Gateway;

use App\Application\Gateway\ParserUrl\ParserUrlGatewayInterface;
use App\Application\Gateway\ParserUrl\ParserUrlGatewayRequest;
use App\Application\Gateway\ParserUrl\ParserUrlGatewayResponse;

class ParserUrlGateway implements ParserUrlGatewayInterface
{

    public function getTitle(ParserUrlGatewayRequest $request): ParserUrlGatewayResponse
    {
        $tag_regex = "'<title>(.*?)</title>'si";

        preg_match($tag_regex,
            file_get_contents($request->url),
            $matches);

        return new ParserUrlGatewayResponse($matches[1]);
    }
}

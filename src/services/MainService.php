<?php

namespace services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use dtos\ResponseDto;


class MainService
{

    public function __construct(
        private BracketsService $bracketsService,
        private SessionService $sessionService,
        private HostService $hostService
    ){
    }

    public function process(): Response
    {
        $request = Request::createFromGlobals();

        /** @var ResponseDto $responseDto */
        $responseDto = $this->bracketsService->validate($request->get('string', ''));

        $message = $responseDto->getMessage();
        $message .= $this->hostService->getHostanmeMessgae();
        $message .= $this->sessionService->getSessinMessage();

        $response = new Response(
            $message,
            $responseDto->getStatus(),
            ['content-type' => 'text/html']
        );

        return $response->send();
    }

}

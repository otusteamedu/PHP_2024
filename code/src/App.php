<?php

declare(strict_types=1);

namespace App;

use App\Command\BracketCheck;
use App\Request\Request;
use App\Response\Response;

class App
{
    /**
     * @return Response
     */
    public function run(): Response
    {
        $request = new Request();
        $response = new Response();

        if ($request->getUri() == '/'){
            $cmd = new BracketCheck();
            $cmd->run($request, $response);
        } else {
            $response->setResultCode(404);
            $response->setContent("Page not found");
        }

        return $response;
    }
}

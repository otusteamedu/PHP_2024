<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Application;

use Viking311\DbPattern\Command\CommandInterface;
use Viking311\DbPattern\Command\GetMovieCommand;
use Viking311\DbPattern\Command\MovieListCommand;
use Viking311\DbPattern\Command\UpdateCommand;
use Viking311\DbPattern\Http\Request\Request;
use Viking311\DbPattern\Http\Response\Response;

class Application
{
    /**
     *
     * @return Response
     */
    public function run(): Response
    {
        $request = new Request();
        $response = new Response();

        if ($request->getUri() != '/') {
            $response->setResultCode(404);
        } else {
            $command = $this->getCommand($request);
            $command->run($request, $response);
        }

        return $response;
    }

    private function getCommand(Request $request): CommandInterface
    {
        switch ($request->getMethod()) {
            case 'GET':
                $query = $request->getQuery();
                if (array_key_exists('id', $query)) {
                    $command = new GetMovieCommand();
                } else {
                    $command = new MovieListCommand();
                }
                break;
            case 'POST':
                $command = new UpdateCommand();
                break;
        }

        return $command;
    }
}

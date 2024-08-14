<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Command;

use Exception;
use Viking311\DbPattern\Http\Request\Request;
use Viking311\DbPattern\Http\Response\Response;
use Viking311\DbPattern\Model\MovieFinderFactory;

class GetMovieCommand implements CommandInterface
{
        /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function run(Request $request, Response $response): void
    {

        $query = $request->getQuery();
        $id = (int) $query['id'];

        try {
            $finder = MovieFinderFactory::getInstance();

            $movie = $finder->getMovieById($id);
            if (!is_null($movie)) {
                $response->setResultCode(200);
                $response->setContent(
                    json_encode($movie)
                );
            } else {
                $response->setResultCode(404);
            }
        } catch (Exception) {
            $response->setResultCode(500);
        }
    }
}

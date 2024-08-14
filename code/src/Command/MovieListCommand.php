<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Command;

use Exception;
use Viking311\DbPattern\Http\Request\Request;
use Viking311\DbPattern\Http\Response\Response;
use Viking311\DbPattern\Model\MovieFinderFactory;

class MovieListCommand implements CommandInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function run(Request $request, Response $response): void
    {
        try {
            $finder = MovieFinderFactory::getInstance();

            $movies = $finder->getMovieList();

            $response->setResultCode(200);
            $response->setContent(
                json_encode($movies)
            );
        } catch (Exception) {
            $response->setResultCode(500);
        }
    }
}

<?php

declare(strict_types=1);

namespace Viking311\DbPattern\Command;

use Exception;
use Viking311\DbPattern\Db\PdoFactory;
use Viking311\DbPattern\Http\Request\Request;
use Viking311\DbPattern\Http\Response\Response;
use Viking311\DbPattern\Model\Movie;

class UpdateCommand implements CommandInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function run(Request $request, Response $response): void
    {
        $body = $request->getBody();

        try {
            $data = json_decode($body);
            if (!is_object($data)) {
                throw new Exception('Not object');
            }

            $movie =  new Movie(
                PdoFactory::getPdo()
            );
            $movie->fromArray(
                (array)$data
            );

            $movie->save();
            $response->setResultCode(200);
            $response->setContent(
                json_encode($movie)
            );
        } catch (Exception) {
            $response->setResultCode(500);
        }
    }
}

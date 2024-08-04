<?php

namespace Ahar\hw15\src\Infrasrtructure\Http;

use Ahar\hw15\src\Application\Contract\CreateNewsInterface;
use Ahar\hw15\src\Application\Contract\UpdateNewsInterface;
use Ahar\hw15\src\Application\Dto\CreateNewsRequest;
use Ahar\hw15\src\Application\Dto\UpdateNewsRequest;

readonly class NewsController
{
    public function __construct(
        private CreateNewsInterface $createNews,
        private UpdateNewsInterface $updateNews,
    )
    {
    }

    public function createCinema(): void
    {
        /// логика ....
        $name = 'Name';
        $description = 'Description';

        $dto = new CreateNewsRequest(
            $name,
            $description,
        );
        $response = $this->createNews->handle($dto);

        http_response_code($response->responseCode);
        echo $response->errorMessage;
    }

    /**
     * @return void
     */
    public function updateCinema()
    {
        /// логика ....
        $name = 'Name';
        $description = 'Description';
        $id = 1;


        $dto = new UpdateNewsRequest(
            $id,
            $name,
            $description
        );
        $response = $this->updateNews->handle($dto);

        http_response_code($response->responseCode);
        echo $response->errorMessage;
    }

}

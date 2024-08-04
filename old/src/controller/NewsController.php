<?php

namespace Ahar\Hw15\src\Infrasrtructure\Http;

use Ahar\Hw15\src\Application\Contract\CreateNewsInterface;
use Ahar\Hw15\src\Application\Contract\UpdateNewsInterface;
use Ahar\Hw15\src\Application\Dto\CreateNewsRequest;
use Ahar\Hw15\src\Application\Dto\UpdateNewsRequest;
use Ahar\Hw15\src\Domain\Repository\NewsRepository;

readonly class NewsController
{
    public function __construct(
        private NewsRepository $newsRepository,
    )
    {
    }

    public function createCinema(): void
    {
        /// логика ....
        $name = 'Name';
        $description = 'Description';

        $response = $this->newsRepository->save([
            'name' => $name,
            'description' => $description
        ]);

        http_response_code(200);
        echo "id {$response}";
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


        $response = $this->newsRepository->save([
            'name' => $name,
            'description' => $description,
            'id' => $id
        ]);

        http_response_code(200);
        echo "id {$response}";
    }

}

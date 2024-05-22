<?php

declare(strict_types=1);

namespace App\Application\Actions\News;

use Slim\Psr7\Response;

class ListNewsAction extends NewsAction
{
    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->newsRepository->findAll();

        $this->logger->info("News list was viewed.");

        return $this->respondWithData($users);
    }
}

<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\Elastic;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RailMukhametshin\Hw\Commands\AbstractCommand;

class OtusShopRemoveIndexCommand extends AbstractCommand
{
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function execute(): void
    {
        $this->otusShopRepository->removeIndex();
        $this->formatter->output('Index deleted');
    }
}

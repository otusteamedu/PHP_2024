<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\Elastic;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use RailMukhametshin\Hw\Commands\AbstractCommand;
use RailMukhametshin\Hw\Repositories\Elastic\OtusShopRepository;

class OtusShopRemoveIndexCommand extends AbstractCommand
{
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function execute(): void
    {
        $otusShopRepository = new OtusShopRepository($this->elasticClient);
        $otusShopRepository->removeIndex();
        $this->formatter->output('Index deleted');
    }
}

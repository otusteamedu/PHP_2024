<?php

declare(strict_types=1);

namespace Viking311\Books\Application;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Viking311\Books\Command\HelpCommand;
use Viking311\Books\Command\SearchCommandFactory;

class Application
{
    /**
     * @throws AuthenticationException
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function run(): void
    {
        $options = getopt("hc:l:e:g:");

        if (empty($options) || array_key_exists('h', $options)) {
            $cmd = new HelpCommand();
            $cmd->run();
        } else {
            $cmd = SearchCommandFactory::createInstance();
            $cmd->run($options);
        }
    }
}

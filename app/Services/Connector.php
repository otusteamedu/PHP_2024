<?php

namespace App\Services;

use App\Contracts\ConnectorInterface;
use Exception;

final readonly class Connector
{
    /**
     * @throws Exception
     */
    public function __construct(public array $connectors)
    {
    }

    /**
     * @throws Exception
     */
    public function client(string $connectorName): ConnectorInterface
    {
        if (
            !array_key_exists($connectorName, $this->connectors)
            || !($this->connectors[$connectorName] instanceof ConnectorInterface)
        ) {
            throw new Exception('not exist connection');
        }

        return $this->connectors[$connectorName];
    }
}

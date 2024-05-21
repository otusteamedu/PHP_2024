<?php
declare(strict_types=1);
namespace App\Application\ClientRun;


use App\Domain\Client\Client;
use App\Domain\TransportInterface\TransportInterface;

class ClientRun
{

    /**
     * @var TransportInterface
     */
    private TransportInterface $transport;

    /**
     * App constructor.
     * @param TransportInterface $transport
     */
    public function __construct(TransportInterface $transport)
    {
        $this->transport = $transport;
    }

    public function run() {
        $client = new Client();
        $client->run($this->transport);
    }
}
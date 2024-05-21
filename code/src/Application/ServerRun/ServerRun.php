<?php
declare(strict_types=1);
namespace App\Application\ServerRun;


use App\Domain\Server\Server;
use App\Domain\TransportInterface\TransportInterface;

class ServerRun
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
        $server = new Server();
        $server->run($this->transport);
    }
}
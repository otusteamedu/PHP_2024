<?php
declare(strict_types=1);
namespace App\Application\ServerRun;


use App\Domain\Server\Server;
use App\Domain\TransportInterface\TransportInterface;

class ServerRun
{

    private string $command;
    const START_SERVER = "server";
    /**
     * @var TransportInterface
     */
    private TransportInterface $transport;


    /**
     * App constructor.
     * @param string $argv
     * @param TransportInterface $transport
     */
    public function __construct(string $argv, TransportInterface $transport)
    {
        $this->command = $argv;
        $this->transport = $transport;
    }

    public function run() {
        if ($this->command === self::START_SERVER) (new Server())->run($this->transport);
    }
}
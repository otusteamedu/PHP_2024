<?php
declare(strict_types=1);
namespace App\Application\ClientRun;


use App\Domain\Client\Client;
use App\Domain\TransportInterface\TransportInterface;

class ClientRun
{

    const START_CLIENT = "client";
    /**
     * @var TransportInterface
     */
    private TransportInterface $transport;
    private string $command;

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
        if ($this->command === self::START_CLIENT) (new Client())->run($this->transport);
    }
}
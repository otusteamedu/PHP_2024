<?php

namespace Otus\Hw5;

use Otus\Hw5\dictionary\ServicesDictionary;

class App
{
    /**
     * @param $participant
     * @return void
     * @throws \Exception
     */
    public function run($participant): void
    {
        if (!array_key_exists($participant, ServicesDictionary::$allowedParticipants)) {
            throw new \Exception('Access is denied!' . PHP_EOL);
        }

        $participant = new ServicesDictionary::$allowedParticipants[$participant];
        $participant->startChat();
    }

}
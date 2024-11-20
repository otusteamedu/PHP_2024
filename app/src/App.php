<?php

namespace Otus\Hw5;

use Otus\Hw5\dictionary\ServicesDictionary;

class App
{
    /**
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        $participant = $this->getParticipant();

        if (!array_key_exists($participant, ServicesDictionary::$allowedParticipants)) {
            throw new \Exception('Access is denied!' . PHP_EOL);
        }

        $participant = new ServicesDictionary::$allowedParticipants[$participant]();
        $participant->startChat();
    }

    /**
     * @return string|null
     */
    private function getParticipant(): ?string
    {
        return $_SERVER['argv'][1] ?? null;
    }
}

<?php
class QueueManager
{
    private $queueFile = '../storage/queue.json';

    public function addToQueue($request)
    {
        $queue = $this->getQueue();
        $queue[] = $request;
        file_put_contents($this->queueFile, json_encode($queue));
    }

    public function getQueue()
    {
        if (!file_exists($this->queueFile)) {
            file_put_contents($this->queueFile, json_encode([]));
        }
        return json_decode(file_get_contents($this->queueFile), true);
    }
}

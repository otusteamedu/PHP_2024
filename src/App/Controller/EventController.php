<?php

namespace App\Controller;

use App\Service\EventService;
use App\Service\Service;
use App\Storage\RedisStorage;

class EventController
{
    private Service $service;

    public function __construct()
    {
        $this->service = new EventService(new RedisStorage());
    }

    public function addEvent($postData)
    {
        $event = $this->service->addEvent($postData);

        header('Content-Type: application/json');
        echo json_encode(get_object_vars($event));
    }

    public function getBestEvent($postData)
    {
        $event = $this->service->getBestEvent($postData);

        header('Content-Type: application/json');
        echo json_encode(get_object_vars($event));
    }

    public function deleteAll()
    {
        $this->service->deleteAll();
    }

    public function migrate()
    {
        $this->service->migrate();
    }
}
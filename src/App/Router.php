<?php

namespace App;

use App\Controller\EventController;

class Router
{
    public static function route()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $postData = file_get_contents('php://input');
        $postData = json_decode($postData, true);
        $method = $_SERVER['REQUEST_METHOD'];

        $eventController = new EventController();

        if ($method === 'POST') {
            switch ($uri) {
                case '/event/add':
                    return $eventController->addEvent($postData);
            }
        }

        if ($method === 'GET') {
            switch ($uri) {
                case '/event/best':
                    return $eventController->getBestEvent($postData);
                case '/event/migrate':
                    return $eventController->migrate();
            }
        }

        if ($method === 'DELETE') {
            switch ($uri) {
                case '/event/delete':
                    return $eventController->deleteAll();
            }
        }

        throw new \Exception('Not found', 404);
    }
}
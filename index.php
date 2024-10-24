<?php

require_once 'src/EventManager.php';

use Src\EventManager;

$eventManager = new EventManager();


$eventManager->addEvent(1500, ['location' => 'New York', 'type' => 'concert'], 'Rock Concert at Central Park');
$eventManager->addEvent(2000, ['location' => 'Los Angeles', 'type' => 'movie'], 'Premiere of the Latest Sci-Fi Movie');
$eventManager->addEvent(2500, ['location' => 'Chicago', 'type' => 'exhibition'], 'Art Exhibition: Modern Art at The Art Institute');
$eventManager->addEvent(3000, ['location' => 'San Francisco', 'type' => 'conference'], 'Tech Conference: Innovations in AI');


$params = ['location' => 'Chicago', 'type' => 'exhibition'];
$bestEvent = $eventManager->getBestEvent($params);

if ($bestEvent) {
    echo "Best Event: " . json_encode($bestEvent) . "\n";
} else {
    echo "No matching event found.\n";
}


$eventManager->clearEvents();

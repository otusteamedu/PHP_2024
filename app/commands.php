<?php

$manager = require __DIR__ . '/src/bootstrap.php';

$command = $argv[1] ?? null;

switch ($command) {
    case 'add':
        $event = json_decode($argv[2] ?? '', true);
        if (!$event) {
            echo "Invalid event data.\n";
        } else {
            echo $manager->addEvent($event);
        }
        break;

    case 'clear':
        $manager->clearEvents();
        break;

    case 'find':
        $params = json_decode($argv[2] ?? '', true);
        if (!$params) {
            echo "Invalid parameters.\n";
        } else {
            echo $manager->findBestEvent($params);
        }
        break;

    default:
        echo "Usage:\n";
        echo "  php commands.php add '{\"priority\":1000,\"conditions\":{\"param1\":1},\"event\":\"::event::\"}'\n";
        echo "  php commands.php clear\n";
        echo "  php commands.php find '{\"param1\":1,\"param2\":2}'\n";
        break;
}
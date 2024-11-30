<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use AnatolyShilyaev\App\App;

$app = new App();
$emails = $app->getEmails();

echo "<ul>";
foreach ($emails as $email) {
    echo "<li>" . $email . " - " . $app->run($email) .  "</li>";
}
echo "</ul>";

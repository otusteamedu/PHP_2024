<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use AnatolyShilyaev\App\App;

$inputString = $_POST['string'];
$app = new App($_POST['string']);
$emails = $app->getEmails();

echo "<ul>";
foreach ($emails as $email) {
    echo "<li>" . $email . " - " . $app->run($email) .  "</li>";
}
echo "</ul>";

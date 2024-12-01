<?php

require_once __DIR__ . '/src/EmailChecker.php';

// Список email для проверки
$emails = [
    'noster2@gmail.com',
    'invalid-email',
    'nonexistent@domain.com'
];

$checker = new EmailChecker();
$results = $checker->checkEmails($emails);

// Вывод результата в консоль
echo str_pad("Email", 30) . str_pad("Validity", 15) . "Existence\n";
echo str_repeat("-", 50) . "\n";

foreach ($results as $result) {
    echo str_pad($result['email'], 30) . str_pad($result['valid'], 15) . $result['exists'] . "\n";
}

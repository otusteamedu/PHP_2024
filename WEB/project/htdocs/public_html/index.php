<?php

require __DIR__ . '../autoload.php';

// Список email-адресов для проверки
$emails = [
    'test@example.com',
    'ivanivanov666',
    'user@domain.com',
    'vasya.petya@sub.domain.com',
    'brus@egine.xyz'
];

// Создаем экземпляр сервиса
$validationService = new EmailValidationService();

// Проверяем каждый email
foreach ($emails as $email) {
    $isValid = $validationService->validateEmail($email);
    echo $email . ' - ' . ($isValid ? 'Valid' : 'Invalid') . "<br>";
}

$validationService = new ValidationService();
$controller = new MainController($validationService);

$response = $controller->handleRequest();

http_response_code($response['code'] ?? 200);
echo $response['message'];

?>
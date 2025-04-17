<?php

declare(strict_types=1);

namespace App;

use App\Controller\EmailVerificationController;
use App\Service\EmailVerifier;

/**
 * Main application class
 */
class App
{
    /**
     * @var EmailVerifier
     */
    private EmailVerifier $emailVerifier;

    /**
     * @var EmailVerificationController
     */
    private EmailVerificationController $controller;

    /**
     * Initialize application components
     */
    public function __construct()
    {
        $this->emailVerifier = new EmailVerifier();
        $this->controller = new EmailVerificationController($this->emailVerifier);
    }

    /**
     * Run the application
     *
     * @return string Application output
     */
    public function run(): string
    {
     // For demonstration purposes
        $emails = [
            'user@example.com',
            'invalid-email',
            'user@nonexistentdomain123456789.com',
            'user@gmail.com'
        ];

        $results = $this->controller->verifyEmails($emails);

        return json_encode($results, JSON_PRETTY_PRINT);
    }
}

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
        // Get email data from a request or configuration
        $emails = $this->getEmailsFromRequest();

        // Verify the emails
        $results = $this->controller->verifyEmails($emails);

        // Return JSON response
        header('Content-Type: application/json');
        return json_encode($results, JSON_PRETTY_PRINT);
    }

    /**
     * Get emails from the request
     *
     * @return array<string>
     */
    private function getEmailsFromRequest(): array
    {
        // Parse email addresses from request parameters
        // This is a simple example - you might want to get this from POST data
        $emailParam = $_GET['emails'] ?? '';

        if (empty($emailParam)) {
            return [];
        }

        // If comma-separated string
        if (is_string($emailParam)) {
            return array_map('trim', explode(',', $emailParam));
        }

        // If array from request
        return $emailParam;
    }
}

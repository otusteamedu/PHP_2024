<?php

use PHPUnit\Framework\TestCase;
use EmailVerifier\EmailVerifierFacade;

class EmailVerifierFacadeTest extends TestCase
{
    public function testVerifyAndFormat()
    {
        $emails = [
            'valid@example.com',
            'invalid-email'
        ];

        $facade = new EmailVerifierFacade();
        $output = $facade->verifyAndFormat($emails);

        $this->assertStringContainsString('valid@example.com', $output);
        $this->assertStringContainsString('Valid', $output);
        $this->assertStringContainsString('Exists', $output);
        $this->assertStringContainsString('invalid-email', $output);
        $this->assertStringContainsString('Invalid', $output);
        $this->assertStringContainsString('Does not exist', $output);
    }
}

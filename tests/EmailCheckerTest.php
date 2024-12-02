<?php

use PHPUnit\Framework\TestCase;
use EmailVerifier\EmailChecker;

class EmailCheckerTest extends TestCase
{
    public function testCheckEmails()
    {
        $checker = new EmailChecker();
        $emails = [
            'valid@example.com',
            'invalid-email'
        ];

        $results = $checker->checkEmails($emails);

        $this->assertCount(2, $results);
        $this->assertEquals('valid@example.com', $results[0]['email']);
        $this->assertTrue($results[0]['valid']);
        $this->assertFalse($results[1]['valid']);
    }
}

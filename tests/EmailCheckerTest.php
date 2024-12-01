<?php

use PHPUnit\Framework\TestCase;

class EmailCheckerTest extends TestCase
{
    public function testCheckEmails()
    {
        $checker = new EmailChecker();
        $emails = [
            'noster2@gmail.com',
            'invalid-email'
        ];

        $results = $checker->checkEmails($emails);

        $this->assertCount(2, $results);
        $this->assertEquals('Valid', $results[0]['valid']);
        $this->assertEquals('Invalid', $results[1]['valid']);
    }
}

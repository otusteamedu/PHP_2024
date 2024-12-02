<?php

use PHPUnit\Framework\TestCase;
use EmailVerifier\ResultFormatter;

class ResultFormatterTest extends TestCase
{
    public function testFormat()
    {
        $formatter = new ResultFormatter();
        $results = [
            [
                'email' => 'noster2@gmail.com',
                'valid' => true,
                'exists' => true
            ],
            [
                'email' => 'invalid-email',
                'valid' => false,
                'exists' => false
            ]
        ];

        $output = $formatter->format($results);

        $this->assertStringContainsString('noster2@gmail.com', $output);
        $this->assertStringContainsString('Valid', $output);
        $this->assertStringContainsString('Exists', $output);
        $this->assertStringContainsString('invalid-email', $output);
        $this->assertStringContainsString('Invalid', $output);
        $this->assertStringContainsString('Does not exist', $output);
    }
}

<?php

declare(strict_types=1);

namespace Tests\Service;

use App\Service\EmailVerifier;
use PHPUnit\Framework\TestCase;

class EmailVerifierTest extends TestCase
{
    private EmailVerifier $emailVerifier;

    protected function setUp(): void
    {
        $this->emailVerifier = new EmailVerifier();
    }

    /**
     * @dataProvider validEmailProvider
     */
    public function testValidEmails(string $email): void
    {
        $this->assertTrue($this->emailVerifier->isValidEmail($email));
    }

    /**
     * @dataProvider invalidEmailProvider
     */
    public function testInvalidEmails(string $email): void
    {
        $this->assertFalse($this->emailVerifier->isValidEmail($email));
    }

    /**
     * @dataProvider emailListProvider
     */
    public function testEmailList(array $emails, array $expected): void
    {
        $results = $this->emailVerifier->verifyEmails($emails);
        $this->assertEquals($expected, $results);
    }

    public static function validEmailProvider(): array
    {
        return [
            ['user@example.com'],
            ['john.doe@gmail.com'],
            ['info@yandex.ru'],
            ['support@yahoo.com'],
        ];
    }

    public static function invalidEmailProvider(): array
    {
        return [
            ['invalid-email'],
            ['missing@domain'],
            ['@missingusername.com'],
            ['user@nonexistentdomain123456789.com'],
            ['spaces in@email.com'],
        ];
    }

    public static function emailListProvider(): array
    {
        return [
            [
                // Input emails
                [
                    'user@example.com',
                    'invalid-email',
                    'john.doe@gmail.com',
                    'missing@domain'
                ],
                // Expected results
                [
                    'user@example.com' => true,
                    'invalid-email' => false,
                    'john.doe@gmail.com' => true,
                    'missing@domain' => false
                ]
            ]
        ];
    }
}

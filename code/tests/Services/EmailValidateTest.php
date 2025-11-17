<?php declare(strict_types=1);

namespace App\Tests\Services;

use App\Interfaces\EmailValidatorInterface;
use Ekonyaeva\Otus\Services\EmailValidator;
use PHPUnit\Framework\TestCase;

final class EmailValidateTest extends TestCase
{
    public function testInvalidFormatReturnsError(): void
    {
        $validator = new EmailValidator();
        $result = $validator->validate(['invalid']);

        $this->assertArrayHasKey('invalid', $result);
        $r = $result['invalid'];
        $this->assertFalse($r['is_valid']);
        $this->assertFalse($r['is_valid_format']);
        $this->assertNull($r['is_valid_dns']);
        $this->assertContains('Invalid email format', $r['errors']);
    }

    public function testEmailsListValidation(): void
    {
        $validator = new EmailValidator();
        $emails = ['user@', 'fakemail@fake.tz', 'real@email.com', 'somewrongstring'];
        $result = $validator->validate($emails);

        // user@ -> invalid format
        $this->assertArrayHasKey('user@', $result);
        $r = $result['user@'];
        $this->assertFalse($r['is_valid']);
        $this->assertFalse($r['is_valid_format']);
        $this->assertNull($r['is_valid_dns']);
        $this->assertContains('Invalid email format', $r['errors']);

        // somewrongstring -> invalid format
        $this->assertArrayHasKey('somewrongstring', $result);
        $r = $result['somewrongstring'];
        $this->assertFalse($r['is_valid']);
        $this->assertFalse($r['is_valid_format']);
        $this->assertNull($r['is_valid_dns']);
        $this->assertContains('Invalid email format', $r['errors']);

        // fakemail@fake.tz -> valid format, likely no MX
        $this->assertArrayHasKey('fakemail@fake.tz', $result);
        $r = $result['fakemail@fake.tz'];
        $this->assertFalse($r['is_valid']);
        $this->assertTrue($r['is_valid_format']);
        $this->assertFalse($r['is_valid_dns']);
        $this->assertContains('No MX records found for domain', $r['errors']);

        // real@email.com -> valid format and has MX
        $this->assertArrayHasKey('real@email.com', $result);
        $r = $result['real@email.com'];
        $this->assertTrue($r['is_valid']);
        $this->assertTrue($r['is_valid_format']);
        $this->assertTrue($r['is_valid_dns']);
        $this->assertEmpty($r['errors']);
    }
}

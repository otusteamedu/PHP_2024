<?php

namespace Anatolyshilyaev\Tests\Domain\ValueObject;

use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testCanBeCreatedWithValidUrl(): void
    {
        $url = new Url('https://www.example.com');

        $this->assertInstanceOf(Url::class, $url);
        $this->assertEquals('https://www.example.com', $url->getValue());
    }

    public function testThrowsExceptionForInvalidUrl(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Wrong URL format');

        new Url('invalid-url');
    }

    public function testGetValueReturnsCorrectUrl(): void
    {
        $url = new Url('https://www.example.com');

        $this->assertEquals('https://www.example.com', $url->getValue());
    }

    public function testCanBeCreatedWithUrlContainingQuery(): void
    {
        $url = new Url('https://www.example.com/path?param=value');

        $this->assertInstanceOf(Url::class, $url);
        $this->assertEquals('https://www.example.com/path?param=value', $url->getValue());
    }

    public function testCanBeCreatedWithUrlContainingFragment(): void
    {
        $url = new Url('https://www.example.com/path#fragment');

        $this->assertInstanceOf(Url::class, $url);
        $this->assertEquals('https://www.example.com/path#fragment', $url->getValue());
    }
}

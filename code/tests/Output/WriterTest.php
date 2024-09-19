<?php

declare(strict_types=1);

namespace Test\Output;

use Viking311\Chat\Output\Writer;
use PHPUnit\Framework\TestCase;

class WriterTest extends TestCase
{
    private $streamFilter;
    protected function setUp(): void
    {
        stream_filter_register('intercept', Intercept::class);
        $this->streamFilter = stream_filter_append(STDOUT, 'intercept');
    }

    protected function tearDown(): void
    {
        stream_filter_remove($this->streamFilter);
    }


    public function testWrite()
    {
        $message = 'Test message';
        $writer = new Writer();
        $writer->write($message);

        $this->assertEquals(
            $message,
            Intercept::$cache
        );
    }
}

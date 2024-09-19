<?php

namespace Test\Input;

use Viking311\Chat\Input\Reader;
use PHPUnit\Framework\TestCase;

class ReaderTest extends TestCase
{
    public function testRead()
    {
        $expected = "test line";
        file_put_contents('/tmp/1.txt', $expected . "\n");

        $in = fopen('/tmp/1.txt', 'r');
        $out = fopen('/tmp/2.txt', 'w+');
        $reader = new Reader($in, $out);
        $expectedPromt = 'Prompt';

        $actual = $reader->readLine($expectedPromt);
        $actualPrompt = file_get_contents('/tmp/2.txt');
        fclose($in);
        fclose($out);

        $this->assertEquals($expectedPromt, $actualPrompt);
        $this->assertEquals($expected, $actual);
    }
}

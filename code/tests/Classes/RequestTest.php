<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\tests\Classes;

use Asyrovatkin\Hw11\Classes\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testGetMethod()
    {
        $_SERVER['REQUEST_METHOD'] = 'Post';
        $expected = 'post';
        $request = new Request();
        $actual = $request->getMethod();
        $this->assertEquals($expected, $actual);
    }

    /**
     * @dataProvider getPathDataProvider
     * @return void
     */
    public function testGetPath($expected, $path)
    {
        $_SERVER['REQUEST_URI'] = $path;
        $request = new Request();
        $actual = $request->getPath();
        $this->assertEquals($expected, $actual[0]);
    }

    public static function getPathDataProvider(): array
    {
        return [
            ['search', '/search'],
            ['search', '/search/'],
            ['search', '/search/some_uri'],
            ['search', '/search/some_uri/'],
            ['search', '/search/some_uri=?asfasf'],
            ['main', '/main'],
            ['main', '/'],
            ['main', ''],
        ];
    }
}
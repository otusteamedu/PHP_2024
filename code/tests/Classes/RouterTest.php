<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Classes;

use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    /**
     * @dataProvider resolveProvider
     * @return void
     */
    public function testResolve(string $method, string $uri, string $expectedFile)
    {
        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects($this->once())->method('getPath')->willReturn([$uri]);
        $request->expects($this->once())->method('getMethod')->willReturn($method);
        $router = new Router($request);
        $this->expectOutputString(file_get_contents($expectedFile));
        $router->resolve();
    }

    public static function resolveProvider(): array
    {
        return [
            ['get', 'main', './src/Views/main.html'],
            ['get', 'search', './src/Views/search.html'],
        ];
    }
}
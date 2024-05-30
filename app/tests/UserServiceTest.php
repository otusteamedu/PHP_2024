<?php


use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @param $login
     * @param $password
     * @param $hasErrors
     * @dataProvider dataForTestHasErrors
     * @throws ReflectionException
     */

    public function testHasErrors($login, $password, $hasErrors)
    {
        $userService = new \ReflectionClass(\App\services\UserService::class);
        $reflectionHasErrors = $userService->getMethod('hasErrors');
        $reflectionHasErrors->setAccessible(true);
        $result = $reflectionHasErrors->invoke(new \App\services\UserService(), ["login" => $login, "password" => $password]);
        $this->assertEquals($hasErrors, $result);
    }

    public function dataForTestHasErrors()
    {
        return [
            ['', '', true],
            ['', '123', true],
            ['123', '', true],
            ['123', '123', false],
        ];


    }

    /**
     * @param $login
     * @param $password
     * @param $hasErrors
     * @dataProvider dataForTestHasErrors
     */

    public function testFillUser($login, $password, $hasErrors)
    {
        $mockUserService = $this->getMockBuilder(\App\services\UserService::class)
            ->onlyMethods(['save'])
            ->getMock();
        $mockUserService->method("save")
            ->willReturn(true);
        $this->assertEquals(true, $mockUserService->hasErrors(['login' => '', 'password'=>""]));
    }

}
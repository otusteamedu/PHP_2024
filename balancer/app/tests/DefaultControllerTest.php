<?php

namespace App\Tests;

use App\Controller\DefaultController;
use PHPUnit\Framework\TestCase;

class DefaultControllerTest extends TestCase
{
    protected function setUp(): void
    {
        $_SERVER['REQUEST_METHOD'] = 'POST';
    }

    protected function tearDown(): void
    {
        $_SERVER['REQUEST_METHOD'] = null;
        $_POST = [];
    }

    private function postRequest(array $data): array
    {
        $_POST = $data;
        $controller = new DefaultController();
        return $controller->handleRequest();
    }

    public function testEmptyString()
    {
        $response = $this->postRequest(['string1' => '']);

        $this->assertEquals(400, $response['status_code']);
        $this->assertEquals('Parameter "string" is required and cannot be empty', $response['body']['error']);
    }

    public function testBalancedString()
    {
        $response = $this->postRequest(['string' => '(()(()))']);

        $this->assertEquals(200, $response['status_code']);
        $this->assertEquals('success', $response['body']['status']);
        $this->assertEquals('String is valid', $response['body']['message']);
        $this->assertEquals('(()(()))', $response['body']['data_received']);
    }

    public function testUnbalancedMoreOpening()
    {
        $response = $this->postRequest(['string' => '(()(()))(']);

        $this->assertEquals(400, $response['status_code']);
        $this->assertEquals('Unbalanced parentheses: more opening than closing brackets', $response['body']['error']);
    }

    public function testUnbalancedMoreClosing()
    {
        $response = $this->postRequest(['string' => '(()))']);

        $this->assertEquals(400, $response['status_code']);
        $this->assertEquals('Unbalanced parentheses: closing bracket without opening at position 4', $response['body']['error']);
    }

    public function testOnlyClosing()
    {
        $response = $this->postRequest(['string' => ')(']);

        $this->assertEquals(400, $response['status_code']);
        $this->assertEquals('Unbalanced parentheses: closing bracket without opening at position 0', $response['body']['error']);
    }
}
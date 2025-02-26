<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\tests\Helpers;

use Asyrovatkin\Hw11\Helpers\InputFormatterToJson;
use PHPUnit\Framework\TestCase;

class InputFormatterToJsonTest extends TestCase
{
    /**
     * @dataProvider formatValidDataProvider
     */
    public function testFormatValid($eventJson, $expectedResult)
    {
        $inputFormatterToJson = new InputFormatterToJson();
        $actualResult = $inputFormatterToJson->format($eventJson);
        $this->assertEquals($expectedResult, $actualResult);
    }

    /**
     * @dataProvider formatValidDataException
     */
    public function testFormatException($eventJson)
    {
        $inputFormatterToJson = new InputFormatterToJson();
        $this->expectExceptionMessage('Проблема с входными данными');
        $inputFormatterToJson->format($eventJson);
    }

    public static function formatValidDataProvider(): array
    {
        return [
            [
                '{priority: 1000,conditions: {param1 = 1},event: {::event::},}',
                [
                    0 =>
                        [
                            'priority' => 1000,
                            'conditions' =>
                                [
                                    'param1' => 1
                                ],

                            'event' => 'eventName'
                        ]
                ]
            ],
            [
                '{priority: 1000,conditions: {param1 = 1},event: {::event::},},
                {priority: 2000,conditions: {param1 = 2,param2 = 2},event: {::event::},},',
                [
                    0 =>
                        [
                            'priority' => 1000,
                            'conditions' =>
                                [
                                    'param1' => 1
                                ],

                            'event' => 'eventName'
                        ],
                    1 =>
                        [
                            'priority' => 2000,
                            'conditions' =>
                                [
                                    'param1' => 2,
                                    'param2' => 2
                                ],
                            'event' => 'eventName'
                        ]
                ]
            ],

        ];
    }

    public static function formatValidDataException(): array
    {
        return [
            ['{priority: 1000, conditions: {param1 = 1}, event: {},}'],
            ['{ 2000,conditions: {param1 = 2,param2 = 2},event: {::event::},}'],
        ];
    }

}
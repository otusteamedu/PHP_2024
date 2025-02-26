<?php

declare(strict_types=1);

namespace Asyrovatkin\Hw11\Builders;

use Asyrovatkin\Hw11\Models\Event;
use PHPUnit\Framework\TestCase;

class EventBuilderTest extends TestCase
{
    /**
     * @dataProvider buildDataProvider
     * @return void
     */
    public function testBuildValidData($data)
    {
        $builder = new EventBuilder();
        $event = $builder->build($data);

        $this->assertThat($event, self::isInstanceOf(Event::class));
    }

    public static function buildDataProvider(): array
    {
        return [[[
            'id' => 1,
            'event' => 'some event',
            'priority' => 10,
            'conditions' => [
                'param1' => 25,
                'param2' => 100,
            ]]]];
    }
}
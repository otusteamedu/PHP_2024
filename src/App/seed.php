<?php

return [
    [
        'priority' => 1000,
        'conditions' => [
            'param1' => 1,
        ],
        'event' => [
            'name' => 'Событие 1'
        ]
    ],
    [
        'priority' => 2000,
        'conditions' => [
            'param1' => 2,
            'param2' => 2,
        ],
        'event' => [
            'name' => 'Событие 2'
        ]
    ],
    [
        'priority' => 3000,
        'conditions' => [
            'param1' => 1,
            'param2' => 2,
        ],
        'event' => [
            'name' => 'Событие 3'
        ]
    ]
];
<?php

return [
    'channels' => [
        [
            'id' => 'channel-1',
            'name' => 'Name channel 1',
            'description' => 'Description channel 1',
            'link' => 'https://www.youtube.com/channel-1',
            'date_created' => '2025-01-20',
            'count_videos' => 2,
            'count_subscribers' => 10,
        ],
        [
            'id' => 'channel-2',
            'name' => 'Name channel 2',
            'description' => 'Description channel 2',
            'link' => 'https://www.youtube.com/channel-2',
            'date_created' => '2025-01-20',
            'count_videos' => 1,
            'count_subscribers' => 35,
        ]
    ],
    'videos' => [
        [
            'id' => 'video-1',
            'name' => 'Name video 1',
            'description' => 'Description video 1',
            'link' => 'https://www.youtube.com/channel-1/watch?v=video-1',
            'date_created' => '2025-01-25',
            'count_likes' => 3,
            'count_dislikes' => 70,
            'count_comments' => 86,
            'channel_id' => 'channel-1',
            'channel' => [
                'id' => 'channel-1',
                'name' => 'Name channel',
                'link' => 'https://www.youtube.com/channel-1',
            ]
        ],
        [
            'id' => 'video-2',
            'name' => 'Name video 2',
            'description' => 'Description video 2',
            'link' => 'https://www.youtube.com/channel-1/watch?v=video-2',
            'date_created' => '2025-01-25',
            'count_likes' => 300,
            'count_dislikes' => 5,
            'count_comments' => 4,
            'channel_id' => 'channel-1',
            'channel' => [
                'id' => 'channel-1',
                'name' => 'Name channel',
                'link' => 'https://www.youtube.com/channel-1',
            ]
        ],
        [
            'id' => 'video-3',
            'name' => 'Name video 3',
            'description' => 'Description video 3',
            'link' => 'https://www.youtube.com/channel-2/watch?v=video-3',
            'date_created' => '2025-01-25',
            'count_likes' => 5,
            'count_dislikes' => 5,
            'count_comments' => 0,
            'channel_id' => 'channel-2',
            'channel' => [
                'id' => 'channel-2',
                'name' => 'Name channel',
                'link' => 'https://www.youtube.com/channel-2',
            ]
        ],
        [
            'id' => 'video-4',
            'name' => 'Name video 4',
            'description' => 'Description video 4',
            'link' => 'https://www.youtube.com/channel-2/watch?v=video-4',
            'date_created' => '2025-01-25',
            'count_likes' => 100,
            'count_dislikes' => 1,
            'count_comments' => 0,
            'channel_id' => 'channel-2',
            'channel' => [
                'id' => 'channel-2',
                'name' => 'Name channel',
                'link' => 'https://www.youtube.com/channel-2',
            ]
        ]
    ]
];
<?php

declare(strict_types=1);

use OpenSearch\SymfonyClientFactory;

use Valen\App\Application\Youtube\UseCase\Channel\AddChannelUseCase;
use Valen\App\Domain\Youtube\Channel;
use Valen\App\Infrastructure\Youtube\Mapper\ChannelMapper;
use Valen\App\Infrastructure\Youtube\Repository\OpenSearchChannelRepository;

require_once __DIR__ . '/vendor/autoload.php';

echo getenv('OPENSEARCH_INITIAL_ADMIN_PASSWORD');

$openSearchClient = (new SymfonyClientFactory())->create([
    'base_uri' => 'http://localhost:9200',
    'auth_basic' => ['admin', 'cf45yokoCF$%!!!!'],
    'verify_peer' => false,
]);
$channelMapper = new ChannelMapper();
$channelRepository = new OpenSearchChannelRepository($openSearchClient, $channelMapper);
$addChannel = new AddChannelUseCase($channelRepository);

$arChannel = [
    'channel_id' => 'UC-lHJZR3Gqxm24_Vd_AJ5Yw',
    'title' => 'Valen',
    'description' => 'Valen',
    'subscriber_count' => 1000,
    'video_count' => 1000,
    'published_at' => '2022-01-01',
];
$channel = Channel::fromArray($arChannel);

print_r($channel);

$addChannel->execute($channel);

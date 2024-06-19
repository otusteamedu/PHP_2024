<?php

declare(strict_types=1);

namespace Alogachev\Homework;



//use function DI\create;
//use function DI\get;

final class App
{
    public function run(): void
    {
        phpinfo();
//        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
//        $dotenv->load();
//        $testDataPath = $_ENV['ELASTICSEARCH_DATA_PATH'] ?? null;
//        if (is_null($testDataPath)) {
//            throw new TestIndexDataNotFoundException();
//        }
//
//        $container = $this->resolveDI();
//        $args = $this->resolveArgs();
//        try {
//            /** @var ElkService $elkService */
//            $elkService = $container->get(ElkService::class);
//            $health = $elkService->getClusterHealthCheckArray();
//            if ($health['status'] === 'red') {
//                throw new ElkRedStatusException();
//            }
//            echo $health['status'] . PHP_EOL;
//            $this->initIndex($elkService, $testDataPath);
//            $this->search($elkService, $args);
//        } catch (ElasticsearchException | RuntimeException $exception) {
//            echo $exception->getMessage() . PHP_EOL;
//        }
    }

//    /**
//     * @throws AuthenticationException
//     */
//    private function resolveDI(): ContainerInterface
//    {
//        $host = $_ENV['ELASTICSEARCH_HOST'];
//        $port = $_ENV['ELASTICSEARCH_PORT'];
//
//        return new Container([
//            Client::class => ClientBuilder::create()
//                ->setHosts(["http://$host:$port"])
//                ->build(),
//            ElkService::class => create()->constructor(
//                get(ElkRepository::class),
//                get(ElkConsoleView::class),
//            ),
//            ElkRepository::class => create()->constructor(
//                get(Client::class)
//            ),
//        ]);
//    }
}

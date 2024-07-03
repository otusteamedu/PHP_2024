1. Запустить контейнеры командой `docker-compose up -d`
1. Зайти в контейнер `php` командой `docker exec -it php sh`. В дальнейшем все команды выполняются в контейнере, если
явно не указано иное
1. Установить зависимости командой `composer install`
1. Создать схему БД командой `php bin/console doctrine:migrations:migrate`
1. Послать запрос `Add user` из коллекции Postman, проверить, что возвращается `success: true` и идентификатор
пользователя
1. Для проверки синхронного запроса добавим 1000 фолловеров командой `php bin/console followers:add 1 1000`
1. Послать запрос `Post tweet` из коллекции Postman, проверить, сколько времени он выполняется
1. Заходим в интерфейс админки RabbitMQ по адресу `localhost:15672`, логин / пароль `user` / `password`, видим, что
там пока нет ни точки обмена, ни консьюмера
1. Запускаем консьюмер командой `php bin/console rabbitmq:consumer tweet.published -m 100`
1. Проверяем в админке RabbitMQ, что появилась точка обмена и очередь с одним консьюмером
1. Меняем значение поля `async` в запросе `Post tweet` из коллекции Postman на 1 и проверяем, сколько времени он будет
выполняться
1. Пошлём ещё несколько запросов и посмотрим в админке RabbitMQ на то, как обрабатываются сообщения по времени
1. Зайти в контейнер `rabbit-mq` командой `docker exec -it rabbit-mq sh` и выполнить в нём команду
    ```shell script
    rabbitmq-plugins enable rabbitmq_consistent_hash_exchange
    ```
1. В файл `config/packages/old_sound_rabbit_mq.yaml` добавляем:
    1. В секцию `old_sound_rabbit_mq.producers`
        ```yaml
        update_feed.received:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        ```
    1. В секцию `old_sound_rabbit_mq.consumers`
        ```yaml
        update_feed.received-0:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-0', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-1:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-1', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-2:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-2', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-3:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-3', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-4:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-4', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-5:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-5', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-6:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-6', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-7:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-7', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-8:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-8', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
        update_feed.received-9:
            connection: default
            exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
            queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-9', routing_key: '1'}
            callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer
            idle_timeout: 300
            idle_timeout_exit_code: 0
            graceful_max_execution:
                timeout: 1800
                exit_code: 0
            qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
       ```
1. Создаём файл `src/Consumer/UpdateFeedReceivedConsumer/Input/Message.php`
    ```php
    <?php
    declare(strict_types=1);
    
    namespace App\Consumer\UpdateFeedReceivedConsumer\Input;
    
    use Symfony\Component\Validator\Constraints;
    
    /**
     * @author Mikhail Kamorin aka raptor_MVK
     *
     * @copyright 2020, raptor_MVK
     */
    final class Message
    {
        /**
         * @var int
         *
         * @Constraints\Regex("/^\d+$/")
         */
        private $tweetId;
    
        /**
         * @var int
         *
         * @Constraints\Regex("/^\d+$/")
         */
        private $recipientId;
    
        public static function createFromQueue(string $messageBody): self
        {
            $message = json_decode($messageBody, true, 512, JSON_THROW_ON_ERROR);
            $result = new self();
            $result->tweetId = $message['tweetId'];
            $result->recipientId = $message['recipientId'];
    
            return $result;
        }
    
        /**
         * @return int
         */
        public function getTweetId(): int
        {
            return $this->tweetId;
        }
    
        /**
         * @return int
         */
        public function getRecipientId(): int
        {
            return $this->recipientId;
        }
    }
    ``` 
1. Создаём файл `src/Consumer/UpdateFeedReceivedConsumer/Consumer.php`
    ```php
    <?php
    declare(strict_types=1);
    
    namespace App\Consumer\UpdateFeedReceivedConsumer;
    
    use App\Consumer\UpdateFeedReceivedConsumer\Input\Message;
    use App\Entity\Tweet;
    use App\Service\FeedService;
    use Doctrine\ORM\EntityManagerInterface;
    use JsonException;
    use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
    use PhpAmqpLib\Message\AMQPMessage;
    use Symfony\Component\Validator\Validator\ValidatorInterface;
    
    /**
     * @author Mikhail Kamorin aka raptor_MVK
     *
     * @copyright 2020, raptor_MVK
     */
    final class Consumer implements ConsumerInterface
    {
        /** @var EntityManagerInterface */
        private $entityManager;
        /** @var ValidatorInterface */
        private $validator;
        /** @var FeedService */
        private $feedService;
    
        public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, FeedService $feedService)
        {
            $this->entityManager = $entityManager;
            $this->validator = $validator;
            $this->feedService = $feedService;
        }
    
        public function execute(AMQPMessage $msg): int
        {
            try {
                $message = Message::createFromQueue($msg->getBody());
                $errors = $this->validator->validate($message);
                if ($errors->count() > 0) {
                    return $this->reject((string)$errors);
                }
            } catch (JsonException $e) {
                return $this->reject($e->getMessage());
            }
    
            $tweetRepository = $this->entityManager->getRepository(Tweet::class);
            $tweet = $tweetRepository->find($message->getTweetId());
            if (!($tweet instanceof Tweet)) {
                return $this->reject(sprintf('Tweet ID %s was not found', $message->getTweetId()));
            }
    
            $this->feedService->putTweet($tweet, $message->getRecipientId());
    
            $this->entityManager->clear();
            $this->entityManager->getConnection()->close();
    
            return self::MSG_ACK;
        }
    
        private function reject(string $error): int
        {
            echo "Incorrect message: $error";
    
            return self::MSG_REJECT;
        }
    }
    ```
1. Добавляем файл `src/Consumer/TweetPublishedConsumer/Output/UpdateFeedMessage.php`
    ```php
    <?php
    declare(strict_types=1);
    
    namespace App\Consumer\TweetPublishedConsumer\Output;
    
    /**
     * @author Mikhail Kamorin aka raptor_MVK
     *
     * @copyright 2020, raptor_MVK
     */
    final class UpdateFeedMessage
    {
        /**
         * @var array
         */
        private $payload;
    
        /**
         * Message constructor.
         * @param array $payload
         */
        public function __construct(int $tweetId, int $followerId)
        {
            $this->payload = ['tweetId' => $tweetId, 'recipientId' => $followerId];  
        }
    
        public function toAMQPMessage(): string
        {
            return json_encode($this->payload, JSON_THROW_ON_ERROR, 512);
        }
    }
    ```
1. В файле `src/Consumer/TweetPublishedConsumer/Consumer.php`
    1. Убираем из зависимостей `FeedService` и добавляем `ProducerInterface`, исправляя конструктор:
        ```php
        /** @var ProducerInterface */
        private $producer;
    
        public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, SubscriptionService $subscriptionService, ProducerInterface $producer)
        {
            $this->entityManager = $entityManager;
            $this->validator = $validator;
            $this->subscriptionService = $subscriptionService;
            $this->producer = $producer;
        }
        ```    
    1. Исправляем метод `execute` (вместо материализации отправляем сообщения через producer)
        ```
        public function execute(AMQPMessage $msg): int
        {
            try {
                $message = Message::createFromQueue($msg->getBody());
                $errors = $this->validator->validate($message);
                if ($errors->count() > 0) {
                    return $this->reject((string)$errors);
                }
            } catch (JsonException $e) {
                return $this->reject($e->getMessage());
            }
        
            $tweetRepository = $this->entityManager->getRepository(Tweet::class);
            $tweet = $tweetRepository->find($message->getTweetId());
            if (!($tweet instanceof Tweet)) {
                return $this->reject(sprintf('Tweet ID %s was not found', $message->getTweetId()));
            }
        
            $followerIds = $this->subscriptionService->getFollowerIds($tweet->getAuthor()->getId());
        
            foreach ($followerIds as $followerId) {
                $this->producer->publish((new UpdateFeedMessage($tweet->getId(), $followerId))->toAMQPMessage(), $followerId);
            }
        
            $this->entityManager->clear();
            $this->entityManager->getConnection()->close();
        
            return self::MSG_ACK;
        }
        ```
1. В файл `config/services.yaml` добавляем инъекцию нового продюсера в консьюмер `TweetPublishedConsumer\Consumer` в
секцию `services`
    ```yaml
    App\Consumer\TweetPublishedConsumer\Consumer:
        autowire: true
        arguments:
            $producer: "@old_sound_rabbit_mq.update_feed.received_producer"
    ```
1. Запускаем все консьюмеры в фоновом режиме командами:
    ```shell script
    php bin/console rabbitmq:consumer tweet.published -m 100 &
    php bin/console rabbitmq:consumer update_feed.received-0 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-1 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-2 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-3 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-4 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-5 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-6 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-7 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-8 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-9 -m 1000 &
    ```
1. Посылаем запрос `Post tweet` из коллекции Postman и проверяем, что сообщение распределилось на новые консьюмеры
1. Добавляем файл `src/Client/StatsdAPIClient`
    ```
    <?php
    
    namespace App\Client;
    
    use Domnikl\Statsd\Client;
    use Domnikl\Statsd\Connection\UdpSocket;
    
    class StatsdAPIClient
    {
        private const DEFAULT_SAMPLE_RATE = 1.0;
        
        /** @var Client */
        private $client;
    
        public function __construct(string $host, int $port, string $namespace)
        {
            $connection = new UdpSocket($host, $port);
            $this->client = new Client($connection, $namespace);
        }
    
        public function increment(string $key, ?float $sampleRate = null, ?array $tags = null)
        {
            $this->client->increment($key, $sampleRate ?? self::DEFAULT_SAMPLE_RATE, $tags ?? []);
        }
    }
    ```
1. В файле `src/Consumer/UpdateFeedReceivedConsumer/Consumer.php`
    1. Добавляем идентификатор консьюмера и `StatsdAPIClient` в конструктор
        ```php
        /** @var StatsdAPIClient */
        private $statsdAPIClient;
        /** @var string */
        private $key;
        
        public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator, FeedService $feedService, StatsdAPIClient $statsdAPIClient, string $key)
        {
            $this->entityManager = $entityManager;
            $this->validator = $validator;
            $this->feedService = $feedService;
            $this->statsdAPIClient = $statsdAPIClient;
            $this->key = $key;
        }
        ```
    1. Добавляем в метод `execute` увеличение счётчика обработанных сообщений конкретным консьюмером
        ```
        public function execute(AMQPMessage $msg): int
        {
            try {
                $message = Message::createFromQueue($msg->getBody());
                $errors = $this->validator->validate($message);
                if ($errors->count() > 0) {
                    return $this->reject((string)$errors);
                }
            } catch (JsonException $e) {
                return $this->reject($e->getMessage());
            }
        
            $tweetRepository = $this->entityManager->getRepository(Tweet::class);
            $tweet = $tweetRepository->find($message->getTweetId());
            if (!($tweet instanceof Tweet)) {
                return $this->reject(sprintf('Tweet ID %s was not found', $message->getTweetId()));
            }
        
            $this->feedService->putTweet($tweet, $message->getFollowerId());
        
            $this->entityManager->clear();
            $this->entityManager->getConnection()->close();
        
            $this->statsdAPIClient->increment($this->key);
            return self::MSG_ACK;
        }
        ```
1. Добавляем в `config/services.yaml` описание сервиса statsd API-клиента и инъекцию идентификаторов в консьюмеры
    ```
    App\Client\StatsdAPIClient:
        arguments:
            - graphite
            - 8125
            - my_app
    
    App\Consumer\UpdateFeedReceivedConsumer\Consumer0:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_0'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer1:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_1'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer2:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_2'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer3:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_3'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer4:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_4'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer5:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_5'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer6:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_6'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer7:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_7'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer8:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_8'

    App\Consumer\UpdateFeedReceivedConsumer\Consumer9:
        class: App\Consumer\UpdateFeedReceivedConsumer\Consumer
        arguments:
            $key: 'update_feed_received_9'
            
    ```
1. В файл `config/packages/old_sound_rabbit_mq.yaml` в секции `old_sound_rabbit_mq.consumers` исправляем коллбэки для
каждого консьюмера на `App\Consumer\UpdateFeedReceivedConsumer\ConsumerK`
    ```yaml
    update_feed.received-0:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-0', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer0
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-1:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-1', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer1
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-2:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-2', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer2
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-3:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-3', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer3
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-4:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-4', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer4
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-5:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-5', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer5
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-6:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-6', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer6
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-7:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-7', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer7
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-8:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-8', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer8
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-9:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-9', routing_key: '1'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer9
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
   ```
1. Перезапускаем все консьюмеры в фоновом режиме командами (при необходимости убиваем старые незавершившиеся):
    ```shell script
    php bin/console rabbitmq:consumer tweet.published -m 100 &
    php bin/console rabbitmq:consumer update_feed.received-0 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-1 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-2 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-3 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-4 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-5 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-6 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-7 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-8 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-9 -m 1000 &
    ```
1. Заходим в Grafana по адресу `localhost:3000` с логином / паролем `admin` / `admin`
1. Добавляем Data source с типом Graphite и url `http://graphite:80`
1. Добавляем Dashboard и Panel
1. Для созданной Panel выбираем `Inspect > Panel JSON`, вставляем в поле содержимое файла `grafana_panel.json` и
сохраняем
1. Посылаем запрос `Post tweet` из коллекции Postman и видим на панели, что распределение между консьюмерами не
особенно равномерное
1. В файл `config/packages/old_sound_rabbit_mq.yaml` в секции `old_sound_rabbit_mq.consumers` исправляем параметры для
каждого консьюмера `updated_feed.received-K` (меняем значение `routing-key` на 20):
    ```yaml
    update_feed.received-0:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-0', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer0
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-1:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-1', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer1
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-2:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-2', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer2
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-3:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-3', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer3
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-4:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-4', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer4
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-5:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-5', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer5
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-6:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-6', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer6
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-7:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-7', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer7
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-8:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-8', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer8
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
    update_feed.received-9:
        connection: default
        exchange_options: {name: 'old_sound_rabbit_mq.update_feed.received', type: x-consistent-hash}
        queue_options: {name: 'old_sound_rabbit_mq.consumer.update_feed.received-9', routing_key: '20'}
        callback: App\Consumer\UpdateFeedReceivedConsumer\Consumer9
        idle_timeout: 300
        idle_timeout_exit_code: 0
        graceful_max_execution:
            timeout: 1800
            exit_code: 0
        qos_options: {prefetch_size: 0, prefetch_count: 1, global: false}
   ```
1. Перезапускаем все консьюмеры в фоновом режиме командами (при необходимости убиваем старые незавершившиеся):
    ```shell script
    php bin/console rabbitmq:consumer tweet.published -m 100 &
    php bin/console rabbitmq:consumer update_feed.received-0 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-1 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-2 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-3 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-4 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-5 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-6 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-7 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-8 -m 1000 &
    php bin/console rabbitmq:consumer update_feed.received-9 -m 1000 &
    ```
1. Ещё раз посылаем запрос `Post tweet` из коллекции Postman и видим на панели, что распределение между консьюмерами
стало гораздо равномернее

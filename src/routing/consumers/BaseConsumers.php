<?php

declare(strict_types=1);

namespace app\routing\consumers;

use app\log\entity\LogCategories;
use app\log\service\Log;
use app\routing\entity\PriorityRange;
use mikemadisonweb\rabbitmq\components\ConsumerInterface;
use OutOfBoundsException;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;
use PHPUnit\Exception;
use Ramsey\Uuid\Uuid;
use Throwable;
use yii\helpers\ArrayHelper;

abstract class BaseConsumers implements ConsumerInterface, LocalConsumerInterface
{
    protected string $requestId;

    public function __construct(protected Log $log)
    {
    }

    final public function execute(AMQPMessage $msg)
    {
        try {
            $this->requestId = $this->getHeaders($msg, 'requestId', Uuid::uuid4()->toString());
            return $this->handler($msg);
        } catch (Exception $e) {
            // @codeCoverageIgnoreStart
            throw $e;
            // @codeCoverageIgnoreEnd
        } catch (Throwable $e) {
            $this->log->error(
                [
                    'exception' => ['message' => $e->getMessage(), 'trace' => $e->getTraceAsString()],
                    'params_queues' => $msg->body,
                    'requestId' => $this->requestId,
                    'className' => static::class,
                ],
                LogCategories::Offer->value
            );

            return self::MSG_REJECT;
        }
    }

    final public function getTransferHeaders(AMQPMessage $msg, array $subHeaders = []): array
    {
        $headers = $this->getAllHeaders($msg);
        $headers['requestId'] = $this->requestId;
        return array_merge($headers, $subHeaders);
    }

    final public function getAllHeaders(AMQPMessage $msg): array
    {
        try {
            $headers = $msg->get('application_headers');
        } catch (OutOfBoundsException $e) {
            $headers = null;
        }

        if (!$headers instanceof AMQPTable) {
            $headers = new AMQPTable([]);
        }

        return $headers->getNativeData();
    }

    protected function getPriority(AMQPMessage $msg): PriorityRange
    {
        $property = (int)ArrayHelper::getValue($msg->get_properties(), 'priority', 1);

        if (!empty($property)) {
            return PriorityRange::tryFrom($property) ?: PriorityRange::MIN;
        }

        return PriorityRange::MIN;
    }

    private function getHeaders(AMQPMessage $msg, string $key, string $default)
    {
        try {
            $headers = $msg->get('application_headers');
        } catch (OutOfBoundsException $e) {
            $headers = null;
        }

        if (!$headers instanceof AMQPTable) {
            $headers = new AMQPTable([]);
        }

        return $headers->offsetGet($key) ?: $default;
    }
}

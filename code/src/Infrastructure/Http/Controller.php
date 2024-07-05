<?php
declare(strict_types=1);


namespace App\Infrastructure\Http;


use App\Application\UseCase\AddStReqToQueueUseCase\AddStReqToQueueUseCase;
use App\Domain\Entity\StatementRequest;
use App\Domain\ValueObject\Dates;
use App\Infrastructure\Queue\RabbitMQ;
use Exception;

class Controller
{

    private array $routes = [];
    private string $prefix;
    private ?string $url = null;

    public function __construct()
    {
        $this->prefix = getenv("API_PREFIX");
        $this->routes = [
            'POST' => 'request',
            'GET' => 'status'
        ];
    }

    private function validateUrl()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = explode('/', $url);

        if (
            count($url) !== 4 ||
            $url[1].'/'.$url[2].'/' !== $this->prefix
        ) {
            return [404 , 'Страница не найдена'];
        }

        if (!array_key_exists($method, $this->routes)) {
            return [405 , 'Метод не поддерживается'];
        }

        foreach ($this->routes as $key => $value) {
            if ($key === $method && $value === $url[3]) {
                $this->url = $this->routes[$key];
            }
        }

        return [400 , 'Не корректный запрос'];
    }

    /**
     * @throws Exception
     */
    public function run(): string
    {
        $error = $this->validateUrl();
        if ($this->url === null) {
            http_response_code($error[0]);
            return $error[1];
        }
        $caseName = $this->url;
        $queueBroker = new RabbitMQ(
            getenv('RABBITMQ_HOST'),
            getenv('RABBITMQ_PORT'),
            getenv('RABBITMQ_USER'),
            getenv('RABBITMQ_PASSWORD'),
            getenv('RABBITMQ_QUEUE_NAME')
        );
        switch ($caseName) {
            case $this->routes['POST']:
                return $this->handleRequest($_POST, $queueBroker);
            case $this->routes['GET']:
                return $this->handleStatus($queueBroker);
            default:
                http_response_code(403);
                return 'Доступ запрещен';
        }
    }

    private function handleRequest(array $post, $queueBroker)
    {
        if (
            array_key_exists('date_from', $post) &&
            array_key_exists('date_to', $post)
        ) {
            $date_from = $post['date_from'];
            $date_to = $post['date_to'];
        } else {
            http_response_code(400);
            return 'Параметры POST не переданы';
        }

        $statementRequest = new StatementRequest(new Dates($date_from, $date_to));
        $addStReqToQueueUseCase = new AddStReqToQueueUseCase($statementRequest, $queueBroker);
        return $addStReqToQueueUseCase();
    }

    private function handleStatus($queueBroker)
    {
    }
}
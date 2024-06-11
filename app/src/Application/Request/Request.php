<?php

declare(strict_types=1);

namespace Kagirova\Hw21\Application\Request;

use Kagirova\Hw21\Domain\Exception\IncorrectJSONFormat;

class Request
{
    public const METHOD_GET = 'GET';
    public const METHOD_POST = 'POST';

    public function __construct(
        public string $method,
        public array $uri,
        public array $data = []
    ) {
    }

    public static function capture()
    {
        $method = $_SERVER['REQUEST_METHOD'];

        $request_data = self::getRequestData($method, $_SERVER['REQUEST_URI']);
        self::checkData($request_data['data']);

        return new self($method, $request_data['uri'], $request_data['data']);
    }

    private static function getRequestData(string $request_method, string $uri): array
    {
        $uriArr = explode('/', trim($uri, '/'));
        $data = [];
        if ($request_method === self::METHOD_POST) {
            $data = json_decode(file_get_contents('php://input'), true);
        }

        return [
            "uri" => $uriArr,
            "data" => $data
        ];
    }

    private static function checkData(array $data_input = null)
    {
        if (!json_encode($data_input)) {
            throw new IncorrectJSONFormat();
        }
    }
}

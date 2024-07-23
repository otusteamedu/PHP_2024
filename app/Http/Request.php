<?php

namespace App\Http;

use App\Http\Exceptions\BadRequestHttpException;

/**
 * Handle requests.
 */
class Request
{
    /**
     * @var string The request path
     */
    public string $path;

    /**
     * @var string The request method
     */
    public string $method;

    /**
     * @var array The query parameters
     */
    public array $queryParams = [];

    /**
     * @var array The body parameters
     */
    public array $bodyParams = [];

    /**
     * Initializes a new Request instance.
     * @throws BadRequestHttpException
     */
    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        if ($queryParams = $_GET) {
            $this->queryParams = $queryParams;
        }

        if ($bodyParams = file_get_contents('php://input')) {
            if (!json_validate($bodyParams)) {
                throw new BadRequestHttpException('Invalid json provided.');
            }

            $this->bodyParams = json_decode($bodyParams, true);
        }
    }
}

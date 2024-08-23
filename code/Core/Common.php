<?php
namespace Core;

class Common
{
    private static array $PARAMS;


    public function __construct()
    {
        self::setParams();
    }

    public static function setParams()
    {
        self::$PARAMS = [
            'GET' => $_GET,
            'POST' => json_decode(file_get_contents('php://input'), true) ?? [],
        ];
    }
    public static function getParams(): array
    {
        return self::$PARAMS;
    }

    public static function showJson(array $array)
    {
        header('Content-Type: application/json');
        $array['hostname'] = $_SERVER['HOSTNAME'];
        $array['session'] = $_SESSION;
        exit(json_encode($array));
    }

    public static function buildSuccess(array $body = [])
    {
        return ['ok' => 1, 'content' => $body];
    }
    public static function buildError(string $error = 'default error', int $code = 400)
    {
        http_response_code($code);
        return ['ok' => 0, 'error' => $error];
    }
}
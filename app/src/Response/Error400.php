<?php


namespace App\Response;


final class Error400
{

    const ERROR = 400;
    const MESSAGE = "Bad request!";

    /**
     * @return void
     */
    public function get()
    {
        $this->getCode400();
        $this->getMessage();
    }

    private function getMessage() {
        echo self::MESSAGE;
    }

    /**
     * @return int
     */
    private function getCode400(): int
    {
        return http_response_code(self::ERROR);
    }

}
<?php


namespace App\Response;


final class Success
{
    const SUCCESS200 = 200;
    const MESSAGE = "That's fine!";

    /**
     * @return void
     */
    public function get()
    {
        $this->getSuccessCode();
        $this->getMessage();
    }

    private function getMessage() {
        echo self::MESSAGE;
    }

    /**
     * @return int
     */
    private function getSuccessCode(): int
    {
        return http_response_code(self::SUCCESS200);
    }

}
<?php


namespace App\Response;


final class Error400
{

    private int $_error400 = 400;
    private string $_msg = "Bad request!";

    /**
     * @return void
     */
    public function getError400()
    {
        $this->ErrorCode400();
        $this->getMessage();
    }

    private function getMessage() {
        echo $this->_msg;
    }

    /**
     * @return int
     */
    private function ErrorCode400(): int
    {
        return http_response_code($this->_error400);
    }

}
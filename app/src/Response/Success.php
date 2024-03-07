<?php


namespace App\Response;


final class Success
{
    private int $_success200 = 200;
    private string $_msg = "That's fine!";

    /**
     * @return void
     */
    public function getSuccess()
    {
        $this->SuccessCode();
        $this->getMessage();
    }

    private function getMessage() {
        echo $this->_msg;
    }

    /**
     * @return int
     */
    private function SuccessCode(): int
    {
        return http_response_code($this->_success200);
    }

}
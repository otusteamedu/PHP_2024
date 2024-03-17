<?php

namespace IraYu\OtusHw4;

class ResponseHTML implements Response
{
    protected Result $result;

    public function setResult(Result $result): Response
    {
        $this->result = $result;

        return $this;
    }
    public function print(): void
    {
        if ($this->result->isSuccess()) {
            header("HTTP/1.1 200 OK");
        } else {
            header("HTTP/1.1 400 Bad Request");
        }
        echo $this->result->getMessage();
    }
}
